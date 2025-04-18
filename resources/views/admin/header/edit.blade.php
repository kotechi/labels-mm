@extends('layouts.admin')

@section('title','Edit Header')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Edit Header</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Header Data</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('headers.update', $header->id) }}" method="POST" enctype="multipart/form-data" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="tittle" class="block text-lg font-medium text-gray-700">Title</label>
                <input type="text" name="tittle" id="tittle" 
                    class="p-3 block w-full border rounded-md @error('tittle') border-red-500 @enderror" 
                    value="{{ $header->tittle }}" required>
                @error('tittle')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" 
                    class="p-3 block w-full border rounded-md @error('description') border-red-500 @enderror" 
                    rows="6" required>{{ $header->description }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="image" class="block text-lg font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="p-3 block w-full border rounded-md @error('image') border-red-500 @enderror">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                
                @if(isset($header->image))
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Current Image:</p>
                    <img src="{{ asset('storage/' . $header->image) }}" alt="{{ $header->tittle }}" class="mt-2 max-h-40">
                </div>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection