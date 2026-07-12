<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%$search%")
                  ->orWhere('email', 'LIKE', "%$search%")
                  ->orWhere('phone', 'LIKE', "%$search%");
            });
        }

        $contacts = $query->latest()->paginate(5);

        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

public function store(Request $request)
{
    $request->validate([
        'name'  => 'required',
        'email' => 'required|email|unique:contacts,email',
        'phone' => 'nullable',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $photoPath = null;

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('contacts', 'public');
    }


    $contact = Contact::create([
        'name'  => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'photo' => $photoPath
    ]);

activity()
    ->causedBy(auth()->user() ?? null)
    ->log('a créé le contact '.$contact->name);


    return redirect('/contacts')
        ->with('success', 'Contact ajouté');
}

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'phone' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $photoPath = $contact->photo;

        if ($request->hasFile('photo')) {

            if ($contact->photo) {
Storage::disk('public')->delete($contact->photo);
            }

            $photoPath = $request->file('photo')->store('contacts', 'public');
        }

        $contact->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'photo' => $photoPath
        ]);
activity()
    ->causedBy(auth()->user() ?? null)
    ->log('a modifié le contact '.$contact->name);
        return redirect('/contacts')->with('success', 'Contact modifié avec succès !');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        if ($contact->photo) {
Storage::disk('public')->delete($contact->photo);        }

        $contact->delete();
activity()
    ->causedBy(auth()->user())
    ->log('a supprimé le contact '.$contact->name);
        return redirect('/contacts')->with('success', 'Contact supprimé avec succès !');
    }
}