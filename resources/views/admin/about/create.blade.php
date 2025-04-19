@extends('layouts.admin')  

@section('title','Create About') 

@section('content') 
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | About</u>
    </div>
</div>

<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Create About Data</h3>
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
        <form action="{{ route('abouts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="tittle" class="block text-lg font-medium text-gray-700">Title</label>
                <input type="text" name="tittle" id="tittle" placeholder="Enter title" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="deskripsi" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="deskripsi" id="deskripsi" placeholder="Enter description" class="p-3 block w-full border rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-lg font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="p-3 block w-full border rounded-md" required>
            </div>
            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection