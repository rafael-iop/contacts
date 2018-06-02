<?php

namespace Tests\Feature\API\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check if contact list is available.
     * 
     * @return void
     */
    public function testIndex()
    {
        $response = $this->json('GET', 'api/contacts');
        $response->assertStatus(200);
    }

    /**
     * Check if API can store a new contact.
     * 
     * @return void
     */
    public function testStore()
    {
        $contact = factory(Contact::class)->make();

        $response = $this->json('POST', 'api/contacts', $contact->toArray());
        $response->assertStatus(201);
    }

    /**
     * Check if API contact resource is equal to contact model.
     * 
     * @return void
     */
    public function testShow()
    {
        $contact = factory(Contact::class)->create();

        $response = $this->json('GET', "api/contacts/{$contact->id}");
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'last_name' => $contact->last_name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                ],
            ]);
    }

    /**
     * Test if API PUT is saving updated contact data.
     * 
     * @return void
     */
    public function testUpdate()
    {
        $contact = factory(Contact::class)->create();
        $updatedData = [
            'name' => 'João',
            'last_name' => 'Silva',
            'email' => 'joao@test.com',
            'phone' => '(41) 12345-6789'
        ];

        $response = $this->json('PUT', "api/contacts/{$contact->id}", $updatedData);
        $response->assertStatus(200);

        $contact = $contact->refresh();
        $this->assertEquals($updatedData['name'], $contact->name);
        $this->assertEquals($updatedData['last_name'], $contact->last_name);
        $this->assertEquals($updatedData['email'], $contact->email);
        $this->assertEquals($updatedData['phone'], $contact->phone);
    }

    /**
     * Check if API DELETE is working.
     * 
     * @return void
     */
    public function testDestroy()
    {
        $contact = factory(Contact::class)->create();

        $response = $this->json('DELETE', "api/contacts/{$contact->id}");
        $response->assertStatus(200);

        $contact = $contact->refresh();
        $this->assertTrue($contact->trashed());
    }

}
