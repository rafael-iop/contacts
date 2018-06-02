<?php

namespace Tests\Unit\Contact;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Unit\CrudInterface;

class ContactTest extends TestCase implements CrudInterface
{
    private $table = 'contacts';

    /**
     * A basic test example.
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

    public function testRead() 
    {
        $contact = factory(Contact::class)->create();
        $contactFound = Contact::find($contact->id);

        $this->assertInstanceOf(Contact::class, $contactFound);
    }

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

    public function testDelete() 
    {
        $contact = factory(Contact::class)->create();
        $deleted = $contact->delete();

        $this->assertTrue($deleted);
        $this->assertSoftDeleted($this->table, ['id' => $contact->id]);
    }

}
