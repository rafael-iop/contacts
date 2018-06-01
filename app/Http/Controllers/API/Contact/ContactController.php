<?php

namespace App\Http\Controllers\API\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Contact\SaveContactRequest;
use App\Http\Requests\Core\OrderRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts.
     *
     * @param  Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, OrderRequest $orderRequest)
    {
        $contacts = Contact::search($request)
            ->orderByFullName($request->orderDirection ?? 'asc')
            ->paginate()
            ->appends($request->only(['search', 'orderDirection']));

        return response()->json($contacts);
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param  \App\Http\Requests\SaveContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveContactRequest $request)
    {
        $contact = Contact::create($request->all());

        return response()->json($contact);
    }

    /**
     * Display the specified contact.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return response()->json($contact);
    }

    /**
     * Update the specified contact in storage.
     *
     * @param  \App\Http\Requests\SaveContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(SaveContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());

        return response()->json($contact);
    }

    /**
     * Remove the specified contact from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([]);
    }

}
