<?php

namespace App\Http\Controllers;

use App\Models\tbl_bahan;
use App\Models\Pengeluaran;
use App\Models\tbl_transaksi;
use Illuminate\Http\Request;

class AdminBahanController extends Controller
{
    public function index()
    {
        $bahans = tbl_bahan::all();
        return view('admin.pengeluaran.index', compact('bahans'));
    }

    public function create()
    {
        return view('admin.bahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'jumlah_bahan' => 'required|integer',
            'harga_satuan' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);

        $bahan = tbl_bahan::create($request->all());

        Pengeluaran::create([
            'id_modal' => $bahan->id_bhn,
            'keterangan' => 'Pengeluaran untuk bahan: ' . $bahan->nama_bahan,
            'nominal_pengeluaran' => $bahan->total_harga,
            'created_by' => auth()->user()->id_users,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create transaction
        tbl_transaksi::create([
            'id_referens' => $bahan->id_bhn,
            'pelaku_transaksi' => auth()->user()->id_users,
            'keterangan' => 'Pembelian bahan: ' . $bahan->nama_bahan. ' seharga: '. $bahan->total_harga .' - (Qty:' . $bahan->jumlah_bahan. ')',
            'nominal' => $bahan->total_harga,
            'kategori' => 'pengeluaran',
            'tanggal' => now(),
        ]);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Bahan created successfully.');
    }

    public function edit(tbl_bahan $bahan)
    {
        return view('admin.bahan.edit', compact('bahan'));
    }

    public function update(Request $request, tbl_bahan $bahan)
    {
        $request->validate([
            'nama_bahan' => 'required',
            'jumlah_bahan' => 'required|integer',
            'harga_satuan' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);

        $bahan->update($request->all());

        $pengeluaran = Pengeluaran::where('id_modal', $bahan->id_bhn)->first();
        if ($pengeluaran) {
            $pengeluaran->update([
                'keterangan' => 'Pengeluaran untuk bahan: ' . $bahan->nama_bahan,
                'nominal_pengeluaran' => $bahan->total_harga,
                'updated_at' => now(),
            ]);
        }

        // Create transaction
        tbl_transaksi::create([
            'id_referens' => $bahan->id_bhn,
            'pelaku_transaksi' => auth()->user()->id_users,
            'keterangan' => 'Update bahan: ' . $bahan->nama_bahan,
            'nominal' => $bahan->total_harga,
            'kategori' => 'pengeluaran',
            'tanggal' => now(),
        ]);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Bahan updated successfully.');
    }

    public function destroy(tbl_bahan $bahan)
    {
        $pengeluaran = Pengeluaran::where('id_modal', $bahan->id_bhn)->first();
        if ($pengeluaran) {
            $pengeluaran->delete();
        }
        $bahan->delete();
        
        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Bahan deleted successfully.');
    }
}
