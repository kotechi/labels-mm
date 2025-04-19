@extends('layouts.admin')

@section('title','Edit About')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Edit About</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit About Data</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('abouts.update', $about->id) }}" method="POST" enctype="multipart/form-data" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="tittle" class="block text-lg font-medium text-gray-700">Title</label>
                <input type="text" name="tittle" id="tittle" 
                    class="p-3 block w-full border rounded-md @error('tittle') border-red-500 @enderror" 
                    value="{{ old('tittle', $about->tittle) }}" required>
                @error('tittle')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="deskripsi" id="deskripsi" 
                    class="p-3 block w-full border rounded-md @error('deskripsi') border-red-500 @enderror" 
                    rows="6" required>{{ old('deskripsi', $about->deskripsi) }}</textarea>
                @error('deskripsi')
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
                
                @if($about->image)
                <div class="mt-2">
                    <p class="text-sm text-gray-500">Current Image:</p>
                    <img src="{{ asset('storage/' . $about->image) }}" alt="{{ $about->tittle }}" class="mt-2 max-h-40">
                </div>
                @endif
            </div>

            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection