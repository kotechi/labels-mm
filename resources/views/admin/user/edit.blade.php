@extends('layouts.admin')

@section('title','Edit User')
@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl">Admin | Edit {{ $user->username }}</u>
    </div>
</div>
<div class="bg-white shadow-md border mt-6">
    <div class="bg-labels shadow-lg rounded-sm">
        <div class="p-4 w-auto">
            <h3 class="text-lg text-white font-semibold">Edit Data User</h3>
        </div>
    </div>
    <div class="p-6 mt-2">
        <form action="{{ route('users.update', ['user' => $user->id_users]) }}" method="POST" onsubmit="this.querySelector('button[type=submit]').disabled = true;">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label for="nama_lengkap" class="block text-lg font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" 
                    class="p-3 block w-full border rounded-md @error('nama_lengkap') border-red-500 @enderror" 
                    value="{{ $user->nama_lengkap }}" required>
                @error('nama_lengkap')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="username" class="block text-lg font-medium text-gray-700">Username</label>
                <input type="text" name="username" id="username" 
                    class="p-3 block w-full border rounded-md @error('username') border-red-500 @enderror" 
                    value="{{ $user->username }}" required>
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-lg font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" 
                    class="p-3 block w-full border rounded-md @error('password') border-red-500 @enderror">
                <small class="text-gray-500">Leave blank to keep current password</small>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-lg font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    class="p-3 block w-full border rounded-md">
            </div>

            <div class="mb-4">
                <label for="usertype" class="block text-lg font-medium text-gray-700">User Type</label>
                <select name="usertype" id="usertype" 
                    class="p-3 block w-full border rounded-md @error('usertype') border-red-500 @enderror" 
                    required>
                    <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="karyawan" {{ $user->usertype == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                </select>
                @error('usertype')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="no_telp" class="block text-lg font-medium text-gray-700">Phone Number</label>
                <input type="text" name="no_telp" id="no_telp" 
                    class="p-3 block w-full border rounded-md @error('no_telp') border-red-500 @enderror" 
                    value="{{ $user->no_telp }}" required>
                @error('no_telp')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <a onclick="history.back()" class="mr-3 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-700">Kembali</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
