<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\tbl_transaksi;
use App\Models\Pemasukan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\MidtransService;

class KaryawanPesananController extends Controller
{
    /** midtrans controller pesanan  **/
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function handleCallback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        
        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $orderId = explode('-', $request->order_id)[1];
                $pesanan = Pesanan::find($orderId);
                
                if ($pesanan) {
                    $pesanan->status_pesanan = 'paid';
                    $pesanan->save();
                    
                    // Create transaction record
                    $transaction = new tbl_transaksi();
                    $transaction->id_referens = $pesanan->id_pesanan;
                    $transaction->pelaku_transaksi = $pesanan->created_by;
                    $transaction->keterangan = 'Payment received via Midtrans';
                    $transaction->nominal = $pesanan->total_harga;
                    $transaction->kategori = 'pemasukan';
                    $transaction->tanggal = now();
                    $transaction->save();
                }
            }
        }
        
        return response()->json(['status' => 'OK']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanans = Pesanan::all();
        return view('karyawan.pesanan.index', compact('pesanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
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
            'lebar_muka' => 'required|numeric',
            'lebar_pundak' => 'required|numeric',
            'lebar_punggung' => 'required|numeric',
            'panjang_lengan' => 'required|numeric',
            'panjang_punggung' => 'required|numeric',
            'panjang_baju' => 'required|numeric',
            'lingkar_badan' => 'required|numeric',
            'lingkar_pinggang' => 'required|numeric',
            'lingkar_panggul' => 'required|numeric',
            'lingkar_kerung_lengan' => 'required|numeric',
            'lingkar_pergelangan_lengan' => 'required|numeric',
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
                return view('karyawan.pesanan.detail', compact('pesanan', 'product'))->with('success', 'berhasil membuat pesanan');
            }

            return redirect()->route('karyawan.pesanans.index')->with('success', 'Pesanan created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    // PesananController.php
    public function generateQRCode(Request $request)
    {
        $amount = $request->amount;

        return response()->json([
            'qr_string' => $qrString 
        ]);
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
        $product = Product::findOrFail($pesanan->product_id);
        return view('karyawan.pesanan.detail', compact('pesanan', 'users', 'product'));
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
            'lebar_muka' => 'required|numeric',
            'lebar_pundak' => 'required|numeric',
            'lebar_punggung' => 'required|numeric',
            'panjang_lengan' => 'required|numeric',
            'panjang_punggung' => 'required|numeric',
            'panjang_baju' => 'required|numeric',
            'lingkar_badan' => 'required|numeric',
            'lingkar_pinggang' => 'required|numeric',
            'lingkar_panggul' => 'required|numeric',
            'lingkar_kerung_lengan' => 'required|numeric',
            'lingkar_pergelangan_lengan' => 'required|numeric',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        
        // Get the currently authenticated user (who is performing the update)
        $currentUser = auth()->user()->id_users;
        
        // Begin transaction
        DB::beginTransaction();
        
        try {
            // Check stock if product changes or quantity increases
            if ($pesanan->product_id != $request->product_id || 
                ($pesanan->product_id == $request->product_id && $pesanan->jumlah_produk < $request->jumlah_produk)) {
                
                $product = Product::find($request->product_id);
                if (!$product) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Produk tidak ditemukan');
                }
                
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
                
                // If changing product, return original quantity to old product if it exists
                if ($pesanan->product_id != $request->product_id) {
                    $oldProduct = Product::find($pesanan->product_id);
                    if ($oldProduct) {
                        $oldProduct->stock_product += $pesanan->jumlah_produk;
                        $oldProduct->save();
                    }
                    
                    // Reduce stock from new product
                    $product->stock_product -= $request->jumlah_produk;
                    $product->save();
                } else {
                    // Same product, just adjust the difference
                    $product->stock_product -= $additionalQuantity;
                    $product->save();
                }
            } elseif ($pesanan->product_id == $request->product_id && $pesanan->jumlah_produk > $request->jumlah_produk) {
                // Returning some items to stock if product still exists
                $product = Product::find($request->product_id);
                if ($product) {
                    $returnedQuantity = $pesanan->jumlah_produk - $request->jumlah_produk;
                    $product->stock_product += $returnedQuantity;
                    $product->save();
                }
            }
            
            // Mengabaikan created_by dari request
            $input = $request->except('created_by');
            
            // Check if total_harga or jumlah_produk has changed
            if ($pesanan->total_harga != $input['total_harga'] || $pesanan->jumlah_produk != $input['jumlah_produk']) {
                // Create transaction tracking
                $transaction = new tbl_transaksi();
                $transaction->id_referens = $pesanan->id_pesanan;
                $transaction->pelaku_transaksi = $currentUser; // Menggunakan user yang sedang login
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
                    $pemasukan->created_by = $currentUser; // Update dengan user yang sedang login
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
                        'pelaku_transaksi' => $currentUser, // Menggunakan user yang sedang login
                        'keterangan' => "Order updated for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                        'nominal' => $pesanan->total_harga,
                        'kategori' => 'pemasukan',
                        'tanggal' => now(),
                    ]);

                    $pemasukan = Pemasukan::where('id_referensi', $pesanan->id_pesanan)->first();
                    if ($pemasukan) {
                        $pemasukan->nominal = $pesanan->total_harga;
                        $pemasukan->created_by = $currentUser; // Update dengan user yang sedang login
                        $pemasukan->save();
                    } else {
                        Pemasukan::create([
                            'id_referensi' => $pesanan->id_pesanan,
                            'keterangan' => "Payment received for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                            'nominal' => $pesanan->total_harga,
                            'created_by' => $currentUser, // Menggunakan user yang sedang login
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

    public function markAsPaid($id)
    {
        try {
            DB::beginTransaction();
    
            $pesanan = Pesanan::findOrFail($id);
            $pesanan->update(['status_pesanan' => 'paid']);
    
            // Use the currently authenticated user instead of the order creator
            $currentUserId = auth()->user()->id_users;
    
            // Create transaction with the current user as the actor
            $transaction = new tbl_transaksi();
            $transaction->id_referens = $pesanan->id_pesanan;
            $transaction->pelaku_transaksi = $currentUserId; // Changed from $pesanan->created_by
            $transaction->keterangan = sprintf(
                'Payment received for Order #%d - %s (Qty: %d)', 
                $pesanan->id_pesanan,
                $pesanan->nama_produk,
                $pesanan->jumlah_produk
            );
            $transaction->nominal = intval($pesanan->total_harga);
            $transaction->kategori = 'pemasukan';
            $transaction->tanggal = now();
            $transaction->save();
    
            // Insert into pemasukan table with the current user
            $pemasukan = new Pemasukan();
            $pemasukan->id_referensi = $pesanan->id_pesanan;
            $pemasukan->keterangan = sprintf(
                'Payment received for Order #%d - %s (Qty: %d)', 
                $pesanan->id_pesanan,
                $pesanan->nama_produk,
                $pesanan->jumlah_produk
            );
            $pemasukan->nominal = intval($pesanan->total_harga);
            $pemasukan->created_by = $currentUserId; // Changed from $pesanan->created_by
            $pemasukan->created_at = now();
            $pemasukan->save();
    
            DB::commit();
    
            return redirect()->route('karyawan.pesanans.index')
                ->with('success', 'Order marked as paid and transaction recorded successfully.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('karyawan.pesanans.index')
                ->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    public function markAsCompleted($id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::findOrFail($id);
            
            // Only allow completing if status is 'paid'
            if ($pesanan->status_pesanan !== 'paid') {
                return redirect()->route('karyawan.pesanans.index')
                    ->with('error', 'Invalid status transition. Order must be paid first.');
            }

            $pesanan->update(['status_pesanan' => 'completed']);

            DB::commit();

            return redirect()->route('karyawan.pesanans.index')
                ->with('success', 'Order marked as completed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('karyawan.pesanans.index')
                ->with('error', 'Failed to complete order: ' . $e->getMessage());
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
        DB::beginTransaction();
    
        try {
            $pesanan = Pesanan::findOrFail($id);
            
            // Hanya kembalikan stok jika produk masih ada
            if ($product = Product::find($pesanan->product_id)) {
                $product->stock_product += $pesanan->jumlah_produk;
                $product->save();
            }
            
            // Hapus pemasukan terkait
            Pemasukan::where('id_referensi', $pesanan->id_pesanan)->delete();
            $pesanan->delete();
    
            DB::commit();
    
            return redirect()->route('karyawan.pesanans.index')
                ->with('success', 'Pesanan dan pemasukan terkait berhasil dihapus');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('karyawan.pesanans.index')
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }
}