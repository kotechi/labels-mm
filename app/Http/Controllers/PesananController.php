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

class PesananController extends Controller
{
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

    public function index()
    {
        return redirect()->route('pemasukan.index');
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.pesanan.create', compact('products'));
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
    
        DB::beginTransaction();
        
        try {
            $request->merge([
                'created_by' => auth()->user()->id_users
            ]);
    
            $pesanan = Pesanan::create($request->all());
    
            $product = Product::findOrFail($request->product_id);
            if ($product->stock_product < $request->jumlah_produk) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
            }
            
            $product->stock_product -= $request->jumlah_produk;
            $product->save();
    
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
                // Make sure to actually get the snap token and check that it exists
                $snapToken = $this->midtransService->createTransaction($pesanan);
                
                if ($snapToken) {
                    return view('admin.pesanan.payment', compact('snapToken', 'pesanan', 'product'));
                }
                
                return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran');
            }
            
            $product = Product::findOrFail($request->product_id);
            
            if ($request->payment_method === 'cash') {
                return view('admin.pesanan.detail', compact('pesanan', 'product'))->with('success', 'berhasil membuat pesanan');
            }
    
            return redirect()->route('pemasukan.index')->with('success', 'Pesanan created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
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
        
        $currentUser = auth()->user()->id_users;
        
        DB::beginTransaction();
        
        try {
            if ($pesanan->product_id != $request->product_id || 
                ($pesanan->product_id == $request->product_id && $pesanan->jumlah_produk < $request->jumlah_produk)) {
                
                $product = Product::find($request->product_id);
                if (!$product) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Produk tidak ditemukan');
                }
                
                $additionalQuantity = 0;
                
                if ($pesanan->product_id == $request->product_id) {
                    $additionalQuantity = $request->jumlah_produk - $pesanan->jumlah_produk;
                } else {
                    $additionalQuantity = $request->jumlah_produk;
                }
                
                if ($product->stock_product < $additionalQuantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Stok produk tidak mencukupi');
                }
                
                if ($pesanan->product_id != $request->product_id) {
                    $oldProduct = Product::find($pesanan->product_id);
                    if ($oldProduct) {
                        $oldProduct->stock_product += $pesanan->jumlah_produk;
                        $oldProduct->save();
                    }
                    
                    $product->stock_product -= $request->jumlah_produk;
                    $product->save();
                } else {
                    $product->stock_product -= $additionalQuantity;
                    $product->save();
                }
            } elseif ($pesanan->product_id == $request->product_id && $pesanan->jumlah_produk > $request->jumlah_produk) {
                $product = Product::find($request->product_id);
                if ($product) {
                    $returnedQuantity = $pesanan->jumlah_produk - $request->jumlah_produk;
                    $product->stock_product += $returnedQuantity;
                    $product->save();
                }
            }
            
            $input = $request->except('created_by');
            
            if ($pesanan->total_harga != $input['total_harga'] || $pesanan->jumlah_produk != $input['jumlah_produk']) {
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

                $pemasukan = Pemasukan::where('id_referensi', $pesanan->id_pesanan)->first();
                if ($pemasukan) {
                    $pemasukan->nominal = intval($input['total_harga']); // Convert to integer if stored as string
                    $pemasukan->created_by = $currentUser; // Update dengan user yang sedang login
                    $pemasukan->save();
                }
            }
            
            $pesanan->update($input);

            if ($pesanan->status_pesanan === 'proses') {
                Pemasukan::where('id_referensi', $pesanan->id_pesanan)->delete();
            } else {
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
            return redirect()->route('pemasukan.index')
                ->with('success', 'Pesanan updated successfully');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

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
        return view('admin.pesanan.edit', compact('pesanan', 'users', 'products'));
    }

    public function detail($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $users = User::all();
        $product = Product::findOrFail($pesanan->product_id);
        return view('admin.pesanan.detail', compact('pesanan', 'users', 'product'));
    }

    public function resi($id) {
        $pesanan = Pesanan::findOrFail($id);
        $product = Product::findOrFail($pesanan->product_id);
        return view('admin.pesanan.resi', compact('pesanan', 'product'));
    }



    public function markAsPaid($id)
    {
        try {
            DB::beginTransaction();
    
            $pesanan = Pesanan::findOrFail($id);
            $pesanan->update(['status_pesanan' => 'paid']);
    
            $currentUserId = auth()->user()->id_users;
    
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
    
            return redirect()->route('pemasukan.index')
                ->with('success', 'Order marked as paid and transaction recorded successfully.');
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('pemasukan.index')
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
                return redirect()->route('pemasukan.index')
                    ->with('error', 'Invalid status transition. Order must be paid first.');
            }

            $pesanan->update(['status_pesanan' => 'completed']);

            DB::commit();

            return redirect()->route('pemasukan.index')
                ->with('success', 'Order marked as completed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pemasukan.index')
                ->with('error', 'Failed to complete order: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        
        try {
            $pesanan = Pesanan::findOrFail($id);
            
            $product = Product::findOrFail($pesanan->product_id);
            $product->stock_product += $pesanan->jumlah_produk;
            $product->save();
            
            $pesanan->delete();
            
            DB::commit();
            return redirect()->route('pemasukan.index')->with('success', 'Pesanan deleted successfully and stock returned.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pemasukan.index')->with('error', 'Failed to delete pesanan: ' . $e->getMessage());
        }
    }

    public function destroyWithPemasukan($id)
    {
        DB::beginTransaction();
    
        try {
            $pesanan = Pesanan::findOrFail($id);
            
            if ($product = Product::find($pesanan->product_id)) {
                $product->stock_product += $pesanan->jumlah_produk;
                $product->save();
            }
            
            Pemasukan::where('id_referensi', $pesanan->id_pesanan)->delete();
            $pesanan->delete();
    
            DB::commit();
    
            return redirect()->route('pemasukan.index')
                ->with('success', 'Pesanan dan pemasukan terkait berhasil dihapus');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pemasukan.index')
                ->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }
}