<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\tbl_transaksi;
use App\Models\Pemasukan;
use App\Models\Product;
use App\Models\User;
use App\Models\Resi;
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
                $orderId = $request->order_id;
                $id_pesanan = preg_replace('/[^0-9]/', '', $orderId);
                $pesanan = \App\Models\Pesanan::find($id_pesanan);
                if ($pesanan) {
                    $pesanan->status_pesanan = 'paid';
                    $pesanan->save();
                }
            }
        }
        // WAJIB: return response 200 OK
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
            'DP_percentage' => 'nullable|numeric',
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
            
            // Kalkulasi harga berdasarkan persentase DP jika dipilih
            $total_harga = $request->total_harga;
            if ($request->has('DP_percentage') && $request->DP_percentage > 0) {
                $total_harga = ($request->total_harga * $request->DP_percentage) / 100;
                $request->merge(['is_DP' => true, 'DP_amount' => $total_harga]);
            } else {
                $request->merge(['is_DP' => false, 'DP_amount' => 0]);
            }
    
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
                    'nominal' => $total_harga,
                    'kategori' => 'pemasukan',
                    'tanggal' => now(),
                ]);
    
                Pemasukan::create([
                    'id_referensi' => $pesanan->id_pesanan,
                    'keterangan' => "Payment received for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                    'nominal' => $total_harga,
                    'created_by' => $pesanan->created_by,
                    'created_at' => now(),
                ]);
                
                // Buat resi jika status sudah dibayar
                $this->createResi($pesanan);
            }
    
            DB::commit();

            // Redirect ke halaman payment setelah create pesanan
            return redirect()->route('pesanans.payment', $pesanan->id_pesanan);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating order: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'nama_produk' => 'required|string|max:255',
            'nama_pemesan' => 'required|string|max:255',
            'status_pesanan' => 'required|string|in:proses,paid,completed',
            'total_harga' => 'required|numeric',
            'jumlah_produk' => 'required|numeric|min:1',
            'no_telp_pemesan' => 'required|string|max:15',
            'DP_percentage' => 'nullable|numeric',
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
            
            // Kalkulasi harga berdasarkan persentase DP jika dipilih
            $total_harga = $request->total_harga;
            if ($request->has('DP_percentage') && $request->DP_percentage > 0) {
                $total_harga = ($request->total_harga * $request->DP_percentage) / 100;
                $input['is_DP'] = true;
                $input['DP_amount'] = $total_harga;
            } else {
                $input['is_DP'] = false;
                $input['DP_amount'] = 0;
            }
            
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
                $transaction->nominal = intval($total_harga); // Convert to integer if stored as string
                $transaction->kategori = 'pemasukan';
                $transaction->tanggal = now();
                $transaction->save();

                $pemasukan = Pemasukan::where('id_referensi', $pesanan->id_pesanan)->first();
                if ($pemasukan) {
                    $pemasukan->nominal = intval($total_harga); // Convert to integer if stored as string
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
                        'nominal' => $total_harga,
                        'kategori' => 'pemasukan',
                        'tanggal' => now(),
                    ]);

                    $pemasukan = Pemasukan::where('id_referensi', $pesanan->id_pesanan)->first();
                    if ($pemasukan) {
                        $pemasukan->nominal = $total_harga;
                        $pemasukan->created_by = $currentUser; // Update dengan user yang sedang login
                        $pemasukan->save();
                    } else {
                        Pemasukan::create([
                            'id_referensi' => $pesanan->id_pesanan,
                            'keterangan' => "Payment received for Order #{$pesanan->id_pesanan} - {$pesanan->nama_produk} (Qty: {$pesanan->jumlah_produk})",
                            'nominal' => $total_harga,
                            'created_by' => $currentUser, // Menggunakan user yang sedang login
                            'created_at' => now(),
                        ]);
                    }
                    
                    $this->createResi($pesanan);
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
        $product = Product::find($pesanan->product_id);
        $resis = Resi::where('pesanan_id', $id)->orderBy('tanggal', 'desc')->get(); // ambil semua resi
        return view('admin.pesanan.detail', compact('pesanan', 'users', 'product', 'resis'));
    }

    public function resi($id) {
        $pesanan = Pesanan::findOrFail($id);
        $product = Product::findOrFail($pesanan->product_id);
        $resi = Resi::where('pesanan_id', $id)->first();
        return view('admin.pesanan.resi', compact('pesanan', 'product', 'resi'));
    }   

    public function markAsPaid($id, Request $request)
    {
        $pesanan = Pesanan::findOrFail($id);
        $product = Product::findOrFail($pesanan->product_id);
        $resi = Resi::where('pesanan_id', $id)->first();
        return view('admin.pesanan.payment', compact('pesanan', 'product', 'resi'));
    }

    public function paymentProses($id, Request $request)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::findOrFail($id);

            if ($pesanan->status_pesanan === 'paid') {
                DB::rollBack();
                return redirect()->route('pemasukan.index')
                    ->with('error', 'Pesanan sudah lunas dan tidak bisa dibayar lagi.');
            }

            $totalHarga = floatval($pesanan->total_harga);
            $jumlahPembayaranLama = floatval($pesanan->jumlah_pembayaran ?? 0);
            $sisaTagihan = $totalHarga - $jumlahPembayaranLama;

            // Ambil nominal pembayaran dari hidden input numerik (bukan dari input format rupiah)
            $bayarBaru = floatval($request->input('jumlah_pembayaran_numeric', 0));

            if ($bayarBaru < 1) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Nominal pembayaran tidak valid.');
            }

            $kembalian = 0;
            if ($bayarBaru > $sisaTagihan) {
                $kembalian = $bayarBaru - $sisaTagihan;
                $bayarBaru = $sisaTagihan;
            }

            $jumlahPembayaranBaru = $jumlahPembayaranLama + $bayarBaru;

            if ($jumlahPembayaranBaru >= $totalHarga) {
                $pesanan->status_pesanan = 'paid';
                $pesanan->jumlah_pembayaran = $totalHarga;
            } else {
                $pesanan->status_pesanan = 'DP';
                $pesanan->jumlah_pembayaran = $jumlahPembayaranBaru;
            }
            $pesanan->save();

            $currentUserId = auth()->user()->id_users;

            $transaction = new tbl_transaksi();
            $transaction->id_referens = $pesanan->id_pesanan;
            $transaction->pelaku_transaksi = $currentUserId;
            $transaction->keterangan = sprintf(
                'Payment received for Order #%d - %s (Qty: %d)', 
                $pesanan->id_pesanan,
                $pesanan->nama_produk,
                $pesanan->jumlah_produk
            );
            $transaction->nominal = intval($bayarBaru);
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
            $pemasukan->nominal = intval($bayarBaru);
            $pemasukan->created_by = $currentUserId; 
            $pemasukan->created_at = now();
            $pemasukan->save();

            $countResi = Resi::where('pesanan_id', $pesanan->id_pesanan)->count();
            $nomorResiFinal = 'RESI-' . date('Ymd') . '-' . $pesanan->id_pesanan . '-' . ($countResi + 1);

            $resi = new Resi();
            $resi->pesanan_id = $pesanan->id_pesanan;
            $resi->nomor_resi = $nomorResiFinal;
            $resi->tanggal = now();
            $resi->total_pembayaran = $totalHarga;
            $resi->jumlah_pembayaran = $jumlahPembayaranBaru;
            $resi->kembalian = $kembalian;
            $resi->created_by = auth()->user()->id_users;
            $resi->save();

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pembayaran berhasil diproses.',
                    'resi_id' => $resi ? $resi->id : null,
                    'kembalian' => $kembalian
                ]);
            }

            return redirect()->route('pemasukan.index')
                ->with('success', 'Pembayaran berhasil diproses.');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memproses pembayaran: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('pemasukan.index')
                ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function payment($id, Request $request)
    {
        $pesanan = Pesanan::findOrFail($id);
        $product = Product::findOrFail($pesanan->product_id);
        $resi = Resi::where('pesanan_id', $id)->first();
        return view('admin.pesanan.payment', compact('pesanan', 'product', 'resi'));
    }

    public function getMidtransToken(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $nominal = floatval($request->input('nominal', 0));
        if ($nominal < 1) {
            return response()->json(['success' => false, 'message' => 'Nominal tidak valid'], 400);
        }
        $snapToken = $this->midtransService->createTransaction($pesanan, $nominal);
        if ($snapToken) {
            return response()->json(['success' => true, 'snapToken' => $snapToken]);
        }
        return response()->json(['success' => false, 'message' => 'Gagal membuat token Midtrans'], 500);
    }

    /**
     * Create a receipt for an order
     * 
     * @param Pesanan $pesanan
     * @return Resi|null
     */
    protected function createResi($pesanan)
    {
        $resi = Resi::where('pesanan_id', $pesanan->id_pesanan)->first();
        
        if (!$resi) {
            $resi = new Resi();
            $resi->pesanan_id = $pesanan->id_pesanan;
            $resi->nomor_resi = 'RESI-' . date('Ymd') . '-' . $pesanan->id_pesanan;
            $resi->tanggal = now();
            $resi->total_pembayaran = $pesanan->is_DP ? $pesanan->DP_amount : $pesanan->total_harga;
            $resi->jumlah_pembayaran = $pesanan->jumlah_pembayaran ?? $resi->total_pembayaran;
            $resi->kembalian = ($pesanan->jumlah_pembayaran ?? $resi->total_pembayaran) - $resi->total_pembayaran;
            $resi->created_by = auth()->user()->id_users;
            $resi->save();
        }
        
        return $resi;
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
            
            // Delete related receipt if exists
            Resi::where('pesanan_id', $id)->delete();
            
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
            
            // Delete related receipt if exists
            Resi::where('pesanan_id', $id)->delete();
            
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

    public function batalkanPesanan($id)
    {
        DB::beginTransaction();

        try {
            $pesanan = Pesanan::findOrFail($id);
            
            if ($product = Product::find($pesanan->product_id)) {
                $product->stock_product += $pesanan->jumlah_produk;
                $product->save();
            }
            
            $currentUserId = auth()->user()->id_users;
            
            $transaction = new tbl_transaksi();
            $transaction->id_referens = $pesanan->id_pesanan;
            $transaction->pelaku_transaksi = $currentUserId;
            $transaction->keterangan = sprintf(
                'Pembatalan pesanan untuk Order #%d - %s (Qty: %d)', 
                $pesanan->id_pesanan,
                $pesanan->nama_produk,
                $pesanan->jumlah_produk
            );
            $transaction->nominal = $pesanan->total_harga;
            $transaction->kategori = 'pembatalan';
            $transaction->tanggal = now();
            $transaction->save();
            
            Pemasukan::where('id_referensi', $pesanan->id_pesanan)->delete();
            
            // Delete related receipt if exists
            Resi::where('pesanan_id', $id)->delete();
            
            $pesanan->status_pesanan = 'batal';
            $pesanan->save();

            DB::commit();

            return redirect()->route('pemasukan.index')
                ->with('success', 'Pesanan berhasil dibatalkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pemasukan.index')
                ->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }
}