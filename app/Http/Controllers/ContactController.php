<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.contacts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Contact::create($request->all());

        return redirect()->route('admin.index')
                         ->with('success', 'Contact created successfully.');
    }


public function landingpage(Request $request)
{
    
    $ip =$request->server->set('REMOTE_ADDR', '123.123.123.123');;
    
    $recentSubmission = Contact::where('ip_address', $ip)
        ->where('created_at', '>', Carbon::now()->subDays(7))
        ->exists();
    
    if ($recentSubmission) {
        return redirect()->route('home')
            ->with('error', 'Anda hanya bisa mengirim pesan sekali per minggu.');
    }

    $validated = $request->validate([
        'nama' => 'required',
        'email' => 'required|email',
        'message' => 'required',
    ]);

    $validated['ip_address'] = $ip;
    
    Contact::create($validated);

    return redirect()->route('home')
        ->with('success', 'Terima kasih atas masukannya!');
}

    public function show(Contact $contact)
    {
        return view('admin.contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        $contact->update($request->all());

        return redirect()->route('admin.index')
                         ->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.index')
                         ->with('success', 'Contact deleted successfully.');
    }
}