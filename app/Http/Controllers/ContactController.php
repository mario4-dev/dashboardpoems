<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'phone' => $contact->phone,
                    'avatar' => $contact->avatar ? asset('storage/' . $contact->avatar) : null,
                    'privacy' => $contact->privacy,
                    'created_at' => $contact->created_at->format('M d, Y'),
                ];
            });

        return Inertia::render('Contacts/Index', [
            'contacts' => $contacts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = auth()->id();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $avatarPath;
        }

        Contact::create($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // Ensure the contact belongs to the authenticated user
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Contacts/Show', [
            'contact' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'phone' => $contact->phone,
                'avatar' => $contact->avatar ? asset('storage/' . $contact->avatar) : null,
                'privacy' => $contact->privacy,
                'created_at' => $contact->created_at->format('M d, Y'),
                'updated_at' => $contact->updated_at->format('M d, Y'),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        // Ensure the contact belongs to the authenticated user
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }

        return Inertia::render('Contacts/Edit', [
            'contact' => [
                'id' => $contact->id,
                'name' => $contact->name,
                'phone' => $contact->phone,
                'avatar' => $contact->avatar ? asset('storage/' . $contact->avatar) : null,
                'privacy' => $contact->privacy,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreContactRequest $request, Contact $contact)
    {
        // Ensure the contact belongs to the authenticated user
        if ($contact->user_id !== auth()->id()) {
            abort(403);
        }

        $validatedData = $request->validated();

        // If no new avatar file is uploaded, don't touch the existing avatar value
        if (! $request->hasFile('avatar')) {
            unset($validatedData['avatar']);
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($contact->avatar) {
                Storage::disk('public')->delete($contact->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $avatarPath;
        }

        $contact->update($validatedData);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
{
    // Ensure the contact belongs to the authenticated user
    if ($contact->user_id !== auth()->id()) {
        abort(403);
    }

    // Delete avatar file if exists
    if ($contact->avatar) {
        Storage::disk('public')->delete($contact->avatar);
    }

    $contact->delete();

    return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully!');
}
}
