@extends('layouts.admin')  

@section('title','Create Contact') 

@section('content') 
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Contact</u>
    </div>
</div>

<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Create Contact Data</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('contacts.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama" class="block text-lg font-medium text-gray-700">Name</label>
                <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Enter name" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Enter email" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="message" class="block text-lg font-medium text-gray-700">Message</label>
                <textarea name="message" id="message" rows="4" placeholder="Enter message" class="p-3 block w-full border rounded-md">{{ old('message') }}</textarea>
            </div>
            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection