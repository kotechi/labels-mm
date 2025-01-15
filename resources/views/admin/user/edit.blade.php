@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit User</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" id="name" class="mt-1 block w-full" value="{{ $user->name }}" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="mt-1 block w-full" value="{{ $user->email }}" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="mt-1 block w-full">
            <small class="text-gray-500">Leave blank to keep current password</small>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full">
        </div>
        <div class="mb-4">
            <label for="usertype" class="block text-sm font-medium text-gray-700">User Type</label>
            <select name="usertype" id="usertype" class="mt-1 block w-full" required>
                <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->usertype == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="max_orders_per_day" class="block text-sm font-medium text-gray-700">Max Orders Per Day</label>
            <input type="number" name="max_orders_per_day" id="max_orders_per_day" class="mt-1 block w-full" value="{{ $user->max_orders_per_day }}" required>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">Update</button>
        </div>
    </form>
</div>
@endsection
