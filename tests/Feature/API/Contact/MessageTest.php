<?php

namespace Tests\Feature\API\Contact;

use App\Models\Contact;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check if contact message list is available.
     * 
     * @return void
     */
    public function testIndex()
    {
        $contact = factory(Contact::class)->create();

        $response = $this->json('GET', "api/contacts/{$contact->id}/messages");
        $response->assertStatus(200);
    }

    /**
     * Check if API can store a new contact message.
     * 
     * @return void
     */
    public function testStore()
    {
        $message = factory(Message::class)->make([
            'contact_id' => factory(Contact::class)->create()
        ]);

        $response = $this->json('POST', "api/contacts/{$message->contact->id}/messages", $message->toArray());
        $response->assertStatus(201);
    }

    /**
     * Check if API contact message resource is equal to contact message model.
     * 
     * @return void
     */
    public function testShow()
    {
        $message = factory(Message::class)->create();

        $response = $this->json('GET', "api/contacts/{$message->contact->id}/messages/{$message->id}");
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $message->id,
                    'contact_id' => $message->contact_id,
                    'description' => $message->description,
                ],
            ]);
    }

    /**
     * Test if API PUT is saving updated contact message data.
     * 
     * @return void
     */
    public function testUpdate()
    {
        $message = factory(Message::class)->create();
        $updatedData = [
            'description' => 'Teste.'
        ];

        $response = $this->json('PUT', "api/contacts/{$message->contact->id}/messages/{$message->id}", $updatedData);
        $response->assertStatus(200);

        $message = $message->refresh();
        $this->assertEquals($updatedData['description'], $message->description);
    }

    /**
     * Check if API DELETE is working.
     * 
     * @return void
     */
    public function testDestroy()
    {
        $message = factory(Message::class)->create();

        $response = $this->json('DELETE', "api/contacts/{$message->contact->id}/messages/{$message->id}");
        $response->assertStatus(200);

        $message = $message->refresh();
        $this->assertTrue($message->trashed());
    }

}
