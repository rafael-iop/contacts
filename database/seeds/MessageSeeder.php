<?php

use App\Models\Contact;
use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$contacts = Contact::all();

    	$contacts->each(function($contact) {
        	factory(Message::class, rand(0, 20))->create([
        		'contact_id' => $contact->id
        	]);
    	});
    }
}
