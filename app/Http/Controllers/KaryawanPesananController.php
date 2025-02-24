<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\tbl_transaksi;
use App\Models\Pemasukan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaryawanPesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::all();
        return view('karyawan.pesanan.index', compact('pesanans'));
    }

    public function create()
    {
        $products = Product::all();
        return view('karyawan.pesanan.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'nama_produk' => 'required|string|max:255',
            'nama_pemesan' => 'required|string|max:255',
            'status_pesanan' => 'required|string|in:proses,paid,completed',
            'total_harga' => 'required|numeric',
            'jumlah_produk' => 'required|numeric|min:1',
            'no_telp_pemesan' => 'required|string|max:15',
            'payment_method' => 'required|string|max:255',
        ]);

        $request->merge(['created_by' => auth()->user()->id_users]);
        $pesanan = Pesanan::create($request->all());

        // Create transaction record
        tbl_transaksi::create([
            'id_referens' => $pesanan->id_pesanan,
            'pelaku_transaksi' => $pesanan->created_by,
            'keterangan' => "Order created for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
            'nominal' => $pesanan->total_harga,
            'kategori' => 'pemasukan',
            'tanggal' => now(),
        ]);

        // Add to pemasukan if status is paid
        if ($pesanan->status_pesanan === 'paid') {
            Pemasukan::create([
                'id_referensi' => $pesanan->id_pesanan,
                'keterangan' => "Payment received for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                'nominal' => $pesanan->total_harga,
                'created_by' => $pesanan->created_by,
                'created_at' => now(),
            ]);
        }

        return redirect()->route('karyawan.pesanans.index')->with('success', 'Pesanan created successfully.');
    }

    public function edit($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('karyawan.pesanan.edit', compact('pesanan', 'users', 'products'));
    }

    public function detail($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('karyawan.pesanan.detail', compact('pesanan', 'users', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id_product',
            'nama_produk' => 'required|string|max:255',
            'nama_pemesan' => 'required|string|max:255',
            'status_pesanan' => 'required|string|in:proses,paid,completed',
            'total_harga' => 'required|numeric',
            'jumlah_produk' => 'required|numeric|min:1',
            'no_telp_pemesan' => 'required|string|max:15',
            'payment_method' => 'required|string|max:255',
            'lebar_muka' => 'nullable|numeric',
            'lebar_pundak' => 'nullable|numeric',
            'lebar_punggung' => 'nullable|numeric',
            'panjang_lengan' => 'nullable|numeric',
            'panjang_punggung' => 'nullable|numeric',
            'panjang_baju' => 'nullable|numeric',
            'lingkar_badan' => 'nullable|numeric',
            'lingkar_pinggang' => 'nullable|numeric',
            'lingkar_panggul' => 'nullable|numeric',
            'lingkar_kerung_lengan' => 'nullable|numeric',
            'lingkar_pergelangan_lengan' => 'nullable|numeric',
        ]);
    
        $pesanan = Pesanan::findOrFail($id);
        
        // Mengabaikan created_by dari request
        $input = $request->except('created_by');
        
        // Check if total_harga or jumlah_produk has changed
        if ($pesanan->total_harga != $input['total_harga'] || $pesanan->jumlah_produk != $input['jumlah_produk']) {
            // Create transaction tracking
            $transaction = new tbl_transaksi();
            $transaction->id_referens = $pesanan->id_pesanan;
            $transaction->pelaku_transaksi = $pesanan->created_by;
            $transaction->keterangan = sprintf(
                'Order updated for Order #%d - %s (Qty: %d)', 
                $pesanan->id_pesanan,
                $pesanan->nama_produk,
                $input['jumlah_produk']
            );
            $transaction->nominal = intval($input['total_harga']); // Convert to integer if stored as string
            $transaction->kategori = 'pemasukan';
            $transaction->tanggal = now();
            $transaction->save();

            // Update associated pemasukan
            $pemasukan = Pemasukan::where('id_referensi', $pesanan->id_pesanan)->first();
            if ($pemasukan) {
                $pemasukan->nominal = intval($input['total_harga']); // Convert to integer if stored as string
                $pemasukan->save();
            }
        }
        $pesanan->update($input);
    
        return redirect()->route('karyawan.pesanans.index')
            ->with('success', 'Pesanan updated successfully');
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('karyawan.pesanans.index')->with('success', 'Pesanan deleted successfully.');
    }

    public function destroyWithPemasukan($id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::findOrFail($id);
            Pemasukan::where('id_referensi', $pesanan->id_pesanan)->delete();
            $pesanan->delete();

            DB::commit();
            return redirect()->route('karyawan.pesanans.index')->with('success', 'Pesanan and associated pemasukan deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('karyawan.pesanans.index')->with('error', 'Failed to delete pesanan: ' . $e->getMessage());
        }
    }

    public function markAsPaid($id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::findOrFail($id);
            $pesanan->update(['status_pesanan' => 'paid']);

            tbl_transaksi::create([
                'id_referensi' => $pesanan->id_pesanan,
                'pelaku_transaksi' => $pesanan->created_by,
                'keterangan' => "Payment received for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                'nominal' => $pesanan->total_harga,
                'kategori' => 'pemasukan',
                'tanggal' => now(),
            ]);

            Pemasukan::create([
                'id_referensi' => $pesanan->id_pesanan,
                'keterangan' => "Payment received for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                'nominal' => $pesanan->total_harga,
                'created_by' => $pesanan->created_by,
                'created_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('karyawan.pesanans.index')->with('success', 'Order marked as paid successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('karyawan.pesanans.index')->with('error', 'Failed to mark as paid: ' . $e->getMessage());
        }
    }

    public function markAsCompleted($id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::findOrFail($id);
            if ($pesanan->status_pesanan !== 'paid') {
                return redirect()->route('karyawan.pesanans.index')->with('error', 'Order must be paid first.');
            }

            $pesanan->update(['status_pesanan' => 'completed']);

            DB::commit();
            return redirect()->route('karyawan.pesanans.index')->with('success', 'Order marked as completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('karyawan.pesanans.index')->with('error', 'Failed to mark as completed: ' . $e->getMessage());
        }
    }
}
