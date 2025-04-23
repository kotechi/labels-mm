<?php

namespace App\Http\Controllers;

use App\Models\tbl_bahan;
use App\Models\Pengeluaran;
use App\Models\tbl_transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'periode_hari' => 'required|integer|min:1',
        ]);
        $bahan = tbl_bahan::create([
            'nama_bahan' => $request->nama_bahan,
            'jumlah_bahan' => $request->jumlah_bahan,
            'harga_satuan' => $request->harga_satuan,
            'total_harga' => $request->total_harga,
            'periode_hari' => $request->periode_hari,
            'id_user' => auth()->user()->id
        ]);

        $periodeHari = $request->periode_hari;
        $totalHarga = $request->total_harga;
        $nominalPerHari = floor($totalHarga / $periodeHari);
        
        $remainder = $totalHarga - ($nominalPerHari * $periodeHari);
        
        for ($day = 0; $day < $periodeHari; $day++) {
            $currentDate = Carbon::now()->addDays($day);
            $nominalToday = $nominalPerHari;
            
            if ($day === 0 && $remainder > 0) {
                $nominalToday += $remainder;
            }
            
            Pengeluaran::create([
                'id_modal' => $bahan->id_bhn,
                'keterangan' => 'Pengeluaran untuk bahan: ' . $bahan->nama_bahan . ' (Hari ' . ($day + 1) . ' dari ' . $periodeHari . ')',
                'nominal_pengeluaran' => $nominalToday,
                'created_by' => auth()->user()->id_users,
                'created_at' => $currentDate,
                'updated_at' => $currentDate,
            ]);
        }

        tbl_transaksi::create([
            'id_referens' => $bahan->id_bhn,
            'pelaku_transaksi' => auth()->user()->id_users,
            'keterangan' => 'Pembelian bahan: ' . $bahan->nama_bahan . ' seharga: ' . $bahan->total_harga . ' - (Qty:' . $bahan->jumlah_bahan . ') untuk ' . $periodeHari . ' hari',
            'nominal' => $bahan->total_harga,
            'kategori' => 'pengeluaran',
            'tanggal' => now(),
        ]);

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Bahan created successfully with expenditures spread over ' . $periodeHari . ' days.');
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
        'periode_hari' => 'required|integer|min:1',
    ]);
    
    $bahan->update([
        'nama_bahan' => $request->nama_bahan,
        'jumlah_bahan' => $request->jumlah_bahan,
        'harga_satuan' => $request->harga_satuan,  // Changed to match form field
        'total_harga' => $request->total_harga,    // Changed to match form field
        'periode_hari' => $request->periode_hari
    ]);

    Pengeluaran::where('id_modal', $bahan->id_bhn)->delete();
    
    $periodeHari = $request->periode_hari;
    $totalHarga = $request->total_harga;
    $nominalPerHari = floor($totalHarga / $periodeHari);
    
    $remainder = $totalHarga - ($nominalPerHari * $periodeHari);
    
    for ($day = 0; $day < $periodeHari; $day++) {
        $currentDate = Carbon::now()->addDays($day);
        $nominalToday = $nominalPerHari;
        
        if ($day === 0 && $remainder > 0) {
            $nominalToday += $remainder;
        }
        
        Pengeluaran::create([
            'id_modal' => $bahan->id_bhn,
            'keterangan' => 'Pengeluaran untuk bahan: ' . $bahan->nama_bahan . ' (Hari ' . ($day + 1) . ' dari ' . $periodeHari . ')',
            'nominal_pengeluaran' => $nominalToday,
            'created_by' => auth()->user()->id_users,
            'created_at' => $currentDate,
            'updated_at' => $currentDate,
        ]);
    }

    tbl_transaksi::create([
        'id_referens' => $bahan->id_bhn,
        'pelaku_transaksi' => auth()->user()->id_users,
        'keterangan' => 'Update bahan: ' . $bahan->nama_bahan . ' (dibagi untuk ' . $periodeHari . ' hari)',
        'nominal' => $bahan->total_harga,
        'kategori' => 'pengeluaran',
        'tanggal' => now(),
    ]);

    return redirect()->route('admin.pengeluaran.index')->with('success', 'Bahan updated successfully with expenditures spread over ' . $periodeHari . ' days.');
}

    public function destroy(tbl_bahan $bahan)
    {
        Pengeluaran::where('id_modal', $bahan->id_bhn)->delete();
        $bahan->delete();
        
        return redirect()->route('admin.pengeluaran.index')
            ->with('success', 'Bahan deleted successfully.');
    }
}