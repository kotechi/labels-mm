@extends('layouts.admin')

@section('title','Edit Contact')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Edit Contact</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Contact Data</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('contacts.update', $contact->id) }}" method="POST" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="nama" class="block text-lg font-medium text-gray-700">Name</label>
                <input type="text" name="nama" id="nama" 
                    class="p-3 block w-full border rounded-md @error('nama') border-red-500 @enderror" 
                    value="{{ old('nama', $contact->nama) }}" required>
                @error('nama')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" 
                    class="p-3 block w-full border rounded-md @error('email') border-red-500 @enderror" 
                    value="{{ old('email', $contact->email) }}" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="message" class="block text-lg font-medium text-gray-700">Message</label>
                <textarea name="message" id="message" rows="4"
                    class="p-3 block w-full border rounded-md @error('message') border-red-500 @enderror">{{ old('message', $contact->message) }}</textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection