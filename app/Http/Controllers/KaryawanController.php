<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Product;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanan::all();
        $products = Product::all();
        $pendingCount = Pesanan::where('status_pesanan', 'proses')->count();
        $paidCount = Pesanan::where('status_pesanan', 'paid')->count();
        $completedCount = Pesanan::where('status_pesanan', 'completed')->count();
        $dp = Pesanan::where('status_pesanan', 'DP')->count();

        return view('karyawan.index', compact('pendingCount', 'paidCount', 'completedCount', 'pesanans', 'products', 'dp'));
    }

    public function profile()
    {
        $user = User::find(auth()->user()->id_users);
        return view('karyawan.profile.index', compact('user'));
    }
    public function profile_update(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id() . ',id_users',
            'password' => 'nullable|string|min:8',
            'no_telp' => 'required|string|max:15'
        ]);
    
        $user = User::find(auth()->user()->id_users);
        
        // Only update password if it's provided
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }
    
        $user->update($validated);
        
        return redirect()->back()->with('status', 'Profile updated successfully');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
