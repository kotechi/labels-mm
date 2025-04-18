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
            'jumlah_produk' => 'required|numeric',
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
            'jumlah_pembayaran' => 'nullable|numeric',
        ]);

        // Begin transaction to ensure data consistency
        DB::beginTransaction();
        
        try {
            $request->merge([
                'created_by' => auth()->user()->id_users
            ]);

            // Create the order
            $pesanan = Pesanan::create($request->all());

            // Update product stock
            $product = Product::findOrFail($request->product_id);
            if ($product->stock_product < $request->jumlah_produk) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
            }
            
            // Decrease product stock
            $product->stock_product -= $request->jumlah_produk;
            $product->save();

            // Add to pemasukan and transaksi if status is paid or completed
            if (in_array($pesanan->status_pesanan, ['paid', 'completed'])) {
                tbl_transaksi::create([
                    'id_referens' => $pesanan->id_pesanan,
                    'pelaku_transaksi' => $pesanan->created_by,
                    'keterangan' => "Order created for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
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
            }

            DB::commit();

            if ($request->payment_method === 'midtrans') {
                $snapToken = $this->midtransService->createTransaction($pesanan);
                
                if ($snapToken) {
                    return view('karyawan.pesanan.payment', compact('snapToken', 'pesanan'))->with('succes', 'Berhasil membuat pesanan');
                }
                
                return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran');
            }
            
            // For cash payments, fetch the product and show receipt
            $product = Product::findOrFail($request->product_id);
            
            // If this is a cash payment, return receipt view
            if ($request->payment_method === 'cash') {
                return view('karyawan.pesanan.resi', compact('pesanan', 'product'))->with('success', 'berhasil membuat pesanan');
            }

            return redirect()->route('pemasukan.index')->with('success', 'Pesanan created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
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

    public function resi($id) {
        $pesanan = Pesanan::findOrFail($id);
        $product = Product::findOrFail($pesanan->product_id);
        return view('karyawan.pesanan.resi', compact('pesanan', 'product'));
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
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Check stock if product changes or quantity increases
            if ($pesanan->product_id != $request->product_id || 
                ($pesanan->product_id == $request->product_id && $pesanan->jumlah_produk < $request->jumlah_produk)) {
                
                $product = Product::findOrFail($request->product_id);
                $additionalQuantity = 0;
                
                if ($pesanan->product_id == $request->product_id) {
                    // Same product, calculate additional quantity
                    $additionalQuantity = $request->jumlah_produk - $pesanan->jumlah_produk;
                } else {
                    // Different product, need full quantity
                    $additionalQuantity = $request->jumlah_produk;
                }
                
                // Check if enough stock is available
                if ($product->stock_product < $additionalQuantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
                }
                
                // If changing product, return original quantity to old product
                if ($pesanan->product_id != $request->product_id) {
                    $oldProduct = Product::findOrFail($pesanan->product_id);
                    $oldProduct->stock_product += $pesanan->jumlah_produk;
                    $oldProduct->save();
                    
                    // Reduce stock from new product
                    $product->stock_product -= $request->jumlah_produk;
                    $product->save();
                } else {
                    // Same product, just adjust the difference
                    $product->stock_product -= $additionalQuantity;
                    $product->save();
                }
            } elseif ($pesanan->product_id == $request->product_id && $pesanan->jumlah_produk > $request->jumlah_produk) {
                // Returning some items to stock
                $product = Product::findOrFail($request->product_id);
                $returnedQuantity = $pesanan->jumlah_produk - $request->jumlah_produk;
                $product->stock_product += $returnedQuantity;
                $product->save();
            }
            
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
    
            // Remove pemasukan if status is changed to 'proses'
            if ($pesanan->status_pesanan === 'proses') {
                Pemasukan::where('id_referensi', $pesanan->id_pesanan)->delete();
            } else {
                // Add to pemasukan and transaksi if status is paid or completed
                if (in_array($pesanan->status_pesanan, ['paid', 'completed'])) {
                    tbl_transaksi::create([
                        'id_referens' => $pesanan->id_pesanan,
                        'pelaku_transaksi' => $pesanan->created_by,
                        'keterangan' => "Order updated for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                        'nominal' => $pesanan->total_harga,
                        'kategori' => 'pemasukan',
                        'tanggal' => now(),
                    ]);
    
                    $pemasukan = Pemasukan::where('id_referensi', $pesanan->id_pesanan)->first();
                    if ($pemasukan) {
                        $pemasukan->nominal = $pesanan->total_harga;
                        $pemasukan->save();
                    } else {
                        Pemasukan::create([
                            'id_referensi' => $pesanan->id_pesanan,
                            'keterangan' => "Payment received for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                            'nominal' => $pesanan->total_harga,
                            'created_by' => $pesanan->created_by,
                            'created_at' => now(),
                        ]);
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('karyawan.pesanans.index')
                ->with('success', 'Pesanan updated successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Begin transaction
        DB::beginTransaction();
        
        try {
            $pesanan = Pesanan::findOrFail($id);
            
            // Return the product stock
            $product = Product::findOrFail($pesanan->product_id);
            $product->stock_product += $pesanan->jumlah_produk;
            $product->save();
            
            // Delete the order
            $pesanan->delete();
            
            DB::commit();
            return redirect()->route('karyawan.pesanans.index')->with('success', 'Pesanan deleted successfully and stock returned.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('karyawan.pesanans.index')->with('error', 'Failed to delete pesanan: ' . $e->getMessage());
        }
    }
    
    public function destroyWithPemasukan($id)
    {
        try {
            DB::beginTransaction();
    
            $pesanan = Pesanan::findOrFail($id);
            
            // Return the product stock
            $product = Product::findOrFail($pesanan->product_id);
            $product->stock_product += $pesanan->jumlah_produk;
            $product->save();
            
            // Delete related records
            Pemasukan::where('id_referensi', $pesanan->id_pesanan)->delete();
            $pesanan->delete();
    
            DB::commit();
            return redirect()->route('karyawan.pesanans.index')->with('success', 'Pesanan and associated pemasukan deleted successfully. Stock has been returned.');
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
                'id_referens' => $pesanan->id_pesanan,
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
