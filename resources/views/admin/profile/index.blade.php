@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl" >Admin | Profile</u>
    </div>
</div>

<div class="flex mt-6  bg-white shadow-2xl">
    <!-- Left Side with Logo -->
    <div class="w-1/3 bg-gray-200 flex items-center justify-center">
        <img src="{{ asset('storage/images/icon/LAblesMM.png') }}" alt="Labels Fashion Logo" class="w-86">
    </div>

    <!-- Right Side with Form -->
    <div class="w-2/3 p-12">
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-center text-purple-700 text-2xl font-bold mb-8">Your Profile</h1>

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-2">
                <label for="nama_lengkap" class="block text-gray-700">Nama Lengkap</label>
                <input type="text" 
                       name="nama_lengkap" 
                       id="nama_lengkap" 
                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                       class="w-full px-4 py-2 border border-purple-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                       required>
            </div>

            <div class="space-y-2">
                <label for="username" class="block text-gray-700">Username</label>
                <input type="text" 
                       name="username" 
                       id="username" 
                       value="{{ old('username', $user->username) }}" 
                       class="w-full px-4 py-2 border border-purple-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                       required>
            </div>

            <div class="space-y-2">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       placeholder="kosongkan jika tidak ingin ganti password"
                       class="w-full px-4 py-2 border border-purple-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>

            <div class="space-y-2">
                <label for="no_telp" class="block text-gray-700">No.telepon</label>
                <input type="text" 
                       name="no_telp" 
                       id="no_telp" 
                       value="{{ old('no_telp', $user->no_telp) }}" 
                       class="w-full px-4 py-2 border border-purple-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                       required>
            </div>

            <div class="pt-4">
                <button type="submit" 
                        class="w-full bg-purple-700 text-white px-6 py-3 rounded-md flex items-center justify-center space-x-2 hover:bg-purple-800 transition-colors">
                    <span>Update Profile</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<style>
/* Add these styles to your CSS */
.form-control:focus {
    border-color: #6B46C1;
    box-shadow: 0 0 0 5px rgba(0, 0, 0, 0.507);
}
</style>
@endpush