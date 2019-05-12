<?php

namespace Tests\Unit\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Unit\CrudInterface;

class ContactTest extends TestCase implements CrudInterface
{
    use RefreshDatabase;
    
    private $table = 'contacts';

    /**
     * Check if contact can be created.
     *
     * @return void
     */
    public function testCreate()
    {
        $contact = factory(Contact::class)->make();
        $saved = $contact->save();

        $this->assertTrue($saved);
        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertDatabaseHas($this->table, $contact->toArray());
    }

    /**
     * Check if contact can be read.
     *
     * @return void
     */
    public function testRead() 
    {
        $contact = factory(Contact::class)->create();
        $contactFound = Contact::find($contact->id);

        $this->assertInstanceOf(Contact::class, $contactFound);
    }

    /**
     * Check if contact can be updated.
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
        $updated = $contact->update($updatedData);
        
        $this->assertTrue($updated);
        $this->assertEquals($updatedData['name'], $contact->name);
        $this->assertEquals($updatedData['last_name'], $contact->last_name);
        $this->assertEquals($updatedData['email'], $contact->email);
        $this->assertEquals($updatedData['phone'], $contact->phone);
    }

    /**
     * Check if contact can be deleted.
     *
     * @return void
     */
    public function testDelete() 
    {
        $contact = factory(Contact::class)->create();
        $deleted = $contact->delete();

        $this->assertTrue($deleted);
        $this->assertSoftDeleted($this->table, ['id' => $contact->id]);
    }

    /**
     * Check if setEmailAttribute() model mutator is working.
     * 
     * @return void
     */
    public function testSetLowerCaseEmail()
    {
        $contact = factory(Contact::class)->create([
            'email' => 'EMAIL@TEST.COM'
        ]);

        $this->assertEquals('email@test.com', $contact->email);
    }

    /**
     * Test contact search by email address.
     * 
     * @return void
     */
    public function testSearchByEmail()
    {
        $contact = factory(Contact::class)->create([
            'email' => 'email@test.com'
        ]);

        // Assert it has at least one result
        $searchResult = Contact::searchByEmail('email@test.com')->get();
        $this->assertGreaterThanOrEqual(1, $searchResult->count());

        // Assert it doesn't have results
        $searchResult = Contact::searchByEmail('email@test.com.br')->get();
        $this->assertEquals(0, $searchResult->count());
    }

    /**
     * Test contact search by email phone number.
     * 
     * @return void
     */
    public function testSearchByPhone()
    {
        $contact = factory(Contact::class)->create([
            'phone' => '(41) 12345-6789'
        ]);

        // Assert it has at least one result
        $searchResult = Contact::searchByPhone('(41) 12345-6789')->get();
        $this->assertGreaterThanOrEqual(1, $searchResult->count());

        // Assert it doesn't have results
        $searchResult = Contact::searchByPhone('(42) 12345-6789')->get();
        $this->assertEquals(0, $searchResult->count());
    }

}
