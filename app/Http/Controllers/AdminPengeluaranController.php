<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Models\tbl_bahan;
use Illuminate\Http\Request;

class AdminPengeluaranController extends Controller
{
    public function index()
    {
        $pengeluarans = Pengeluaran::with('user')->get();
        $bahans = tbl_bahan::all();
        return view('admin.pengeluaran.index', compact('pengeluarans', 'bahans'));
    }

    public function create()
    {
        return view('admin.pengeluaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required',
            'nominal_pengeluaran' => 'required|integer',
        ]);
        $request->merge([
            'created_by' => auth()->user()->id_users
        ]);

        Pengeluaran::create($request->all());
        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran created successfully.');
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        $pengeluaran = Pengeluaran::findOrFail($pengeluaran->id_pengeluaran);
        return view('admin.pengeluaran.edit', compact('pengeluaran'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $request->validate([
            'keterangan' => 'required',
            'nominal_pengeluaran' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        $pengeluaran->update($request->all());
        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran updated successfully.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        $pengeluaran->delete();
        return redirect()->route('admin.pengeluaran.index')->with('success', 'Pengeluaran deleted successfully.');
    }
}
