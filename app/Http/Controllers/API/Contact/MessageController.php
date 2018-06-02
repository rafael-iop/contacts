<?php

namespace App\Http\Controllers\API\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\SaveMessageRequest;
use App\Http\Resources\Contact\MessageResource;
use App\Models\Contact;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of contact messages.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function index(Contact $contact)
    {
        $messages = $contact->messages()
            ->orderBy('created_at')
            ->paginate();

        return MessageResource::collection($messages);
    }

    /**
     * Store a newly created contact message in storage.
     *
     * @param  \App\Http\Requests\SaveMessageRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function store(SaveMessageRequest $request, Contact $contact)
    {
        $message = $contact->messages()->create($request->all());

        return response()->json(['id' => $message->id], 201);
    }

    /**
     * Display the specified message.
     *
     * @param  \App\Models\Contact  $contact
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact, Message $message)
    {
        return new MessageResource($message);
    }

    /**
     * Update the specified message in storage.
     *
     * @param  \App\Http\Requests\SaveMessageRequest  $request
     * @param  \App\Models\Contact  $contact
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(SaveMessageRequest $request, Contact $contact, Message $message)
    {
        $message->update($request->all());

        return response()->json();
    }

    /**
     * Remove the specified message from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact, Message $message)
    {
        $message->delete();

        return response()->json();
    }

}
