<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $contacts = Contact::all();

        return view('contact.index', compact('contacts'));
    }


    public function store(ContactStoreRequest $request): Response
    {
        $contact = Contact::create($request->validated());

        $request->session()->flash('contact.id', $contact->id);

        return redirect()->route('contacts.index');
    }

    public function update(ContactUpdateRequest $request, Contact $contact): Response
    {
        $contact->update($request->validated());

        $request->session()->flash('contact.id', $contact->id);

        return redirect()->route('contacts.index');
    }
}
