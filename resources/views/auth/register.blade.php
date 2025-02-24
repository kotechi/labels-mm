@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Register</h1>
    <form method="POST" action="{{ route('register') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
        @csrf
        <div class="mb-4">
            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input id="nama_lengkap" type="text" name="nama_lengkap" class="mt-1 block w-full" value="{{ old('nama_lengkap') }}" required autofocus>
            @error('nama_lengkap')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
            <input id="username" type="text" name="username" class="mt-1 block w-full" value="{{ old('username') }}" required>
            @error('username')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" class="mt-1 block w-full" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="mt-1 block w-full" required>
        </div>
        <div class="mb-4">
            <label for="no_telp" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input id="no_telp" type="text" name="no_telp" class="mt-1 block w-full" value="{{ old('no_telp') }}" required>
            @error('no_telp')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Register</button>
        </div>
    </form>
</div>
@endsection
