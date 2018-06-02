<?php

namespace Tests\Unit\Contact;

use App\Models\Contact;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Unit\CrudInterface;

class MessageTest extends TestCase implements CrudInterface
{
    private $table = 'messages';

    /**
     * Check if message can be created.
     *
     * @return void
     */
    public function testCreate()
    {
        $message = factory(Message::class)->make();
        $saved = $message->save();

        $this->assertTrue($saved);
        $this->assertInstanceOf(Message::class, $message);
        $this->assertDatabaseHas($this->table, $message->toArray());
    }

    /**
     * Check if message can be read.
     *
     * @return void
     */
    public function testRead() 
    {
        $message = factory(Message::class)->create();
        $messageFound = Message::find($message->id);

        $this->assertInstanceOf(Message::class, $messageFound);
    }

    /**
     * Check if message can be updated.
     *
     * @return void
     */
    public function testUpdate() 
    {
        $message = factory(Message::class)->create();
        $updatedData = [
            'description' => 'Teste.'
        ];
        $updated = $message->update($updatedData);
        
        $this->assertTrue($updated);
        $this->assertEquals($updatedData['description'], $message->description);
    }

    /**
     * Check if message can be deleted.
     *
     * @return void
     */
    public function testDelete() 
    {
        $message = factory(Message::class)->create();
        $deleted = $message->delete();

        $this->assertTrue($deleted);
        $this->assertSoftDeleted($this->table, ['id' => $message->id]);
    }

    /**
     * Check if message has a valid contact relationship.
     * 
     * @return void
     */
    public function testHasContactRelationship()
    {
        $message = factory(Message::class)->create();

        $this->assertInstanceOf(Contact::class, $message->contact);
    }

}
