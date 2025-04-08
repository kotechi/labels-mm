<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // Validate the entire users array
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:8|confirmed',
            'usertype' => 'required|string',
            'no_telp' => 'required|string|max:15',
        ]);
    
            User::create($request->all());
    
        return redirect()->route('users.index')
            ->with('success', 'New user created successfully.');
    }

    public function edit($id_users)
    {
        $user = User::where('id_users', $id_users)->firstOrFail();
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id_users)
    {
        $user = User::where('id_users', $id_users)->firstOrFail();

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id_users . ',id_users',
            'password' => 'nullable|string|min:8|confirmed',
            'usertype' => 'required|string|in:admin,karyawan', // Updated validation rule
            'no_telp' => 'required|string|max:15',
        ]);

        $user->update([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'usertype' => $request->usertype,
            'no_telp' => $request->no_telp,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id_users)
    {
        $user = User::where('id_users', $id_users)->firstOrFail();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
