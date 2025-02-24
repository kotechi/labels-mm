<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Pemasukan;
use Illuminate\Support\Facades\Auth;

class PemasukanController extends Controller
{
    public function index()
    {
        $pendingCount = Pesanan::where('status_pesanan', 'proses')->count();
        $paidCount = Pesanan::where('status_pesanan', 'paid')->count();
        $completedCount = Pesanan::where('status_pesanan', 'completed')->count();
        $pesanans = Pesanan::all();
        $pemasukans = Pemasukan::with('user')->get();
        return view('admin.pemasukan.index', compact('pesanans', 'pemasukans', 'pendingCount', 'paidCount', 'completedCount'));
    }

    public function create()
    {
        return view('admin.pemasukan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'nominal' => 'required|integer',
        ]);
        $request->merge([
            'created_by' => auth()->user()->id_users
        ]);

        $data = $request->all();

        Pemasukan::create($data);

        return redirect()->route('pemasukan.index')
            ->with('success', 'Pemasukan created successfully.');
    }

    public function destroy($id_pemasukan)
    {
        try {
            $pemasukan = Pemasukan::findOrFail($id_pemasukan);
            $pemasukan->delete();

            return redirect()->route('pemasukan.index')
                ->with('success', 'Pemasukan deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('pemasukan.index')
                ->with('error', 'Failed to delete pemasukan: ' . $e->getMessage());
        }
    }
}
