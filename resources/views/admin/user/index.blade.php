@extends('layouts.admin')

@section('title', 'User Management')


@section('content')
<div class="p-5 rounded-lg shadow bg-white">
    <div class="flex justify-between items-center">
        <u class="font-extrabold text-3xl" >Admin | User</u>
    </div>
</div>


<div class="mt-6 p-6 shadow-lg bg-white rounded-lg">
    <div class="card-tittle-section">
        <h2 class="card-tittle"> Daftar User</h2>
        <a button href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors mb-4">
            <span class="mr-2">+</span> Create New User
        </a>
    </div>
    <div class="overflow-x-auto">
        <table  class="datatable min-w-full divide-y divide-gray-200">
            <thead class="bg-thead">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Nama Lengkap</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Username</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">Usertype</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider border-r border-gray-200">No Telp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $id = 0;
                ?>
                @foreach($users as $user)
                <?php
                $id++
                ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{$id}}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->nama_lengkap }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->username }}</td>
                    <td class="px-6 py-4">{{ $user->usertype }}</td>
                    <td class="px-6 py-4">{{ $user->no_telp }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('users.edit', ['user' => $user->id_users]) }}" class="px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md">Edit</a>
                        <form action="{{ route('users.destroy', ['user' => $user->id_users]) }}" method="POST" class="inline-block delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection
