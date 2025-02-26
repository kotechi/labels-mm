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
        return redirect()->route('pemasukan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.pesanan.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
        ]);

        $request->merge([
            'created_by' => auth()->user()->id_users
        ]);

        $pesanan = Pesanan::create($request->all());

        if ($request->payment_method === 'midtrans') {
            $snapToken = $this->midtransService->createTransaction($pesanan);
            
            if ($snapToken) {
                return view('admin.pesanan.payment', compact('snapToken', 'pesanan'));
            }
            
            return redirect()->back()->with('error', 'Gagal membuat transaksi pembayaran');
        }
    }

    // PesananController.php
    public function generateQRCode(Request $request)
    {
        $amount = $request->amount;
        // Di sini Anda bisa menambahkan logika untuk generate QR code sesuai
        // dengan spesifikasi QRIS dari payment gateway yang Anda gunakan
        
        return response()->json([
            'qr_string' => $qrString // String untuk generate QR code
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
        $products = Product::all();
        return view('admin.pesanan.detail', compact('pesanan', 'users', 'products'));
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
    
        return redirect()->route('pesanans.index')
            ->with('success', 'Pesanan updated successfully');
    }

    public function markAsPaid($id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::findOrFail($id);
            

            // Update order status
            $pesanan->status_pesanan = 'paid';
            $pesanan->save();

            // Create transaction with explicit field mapping
            $transaction = new tbl_transaksi();
            $transaction->id_referens = $pesanan->id_pesanan;
            $transaction->pelaku_transaksi = $pesanan->created_by;
            $transaction->keterangan = sprintf(
                'Payment received for Order #%d - %s (Qty: %d)', 
                $pesanan->id_pesanan,
                $pesanan->nama_produk,
                $pesanan->jumlah_produk
            );
            $transaction->nominal = intval($pesanan->total_harga); // Convert to integer if stored as string
            $transaction->kategori = 'pemasukan';
            $transaction->tanggal = now();
            
            
            $transaction->save();

            // Insert into pemasukan table
            $pemasukan = new Pemasukan();
            $pemasukan->id_referensi = $pesanan->id_pesanan;
            $pemasukan->keterangan = sprintf(
                'Payment received for Order #%d - %s (Qty: %d)', 
                $pesanan->id_pesanan,
                $pesanan->nama_produk,
                $pesanan->jumlah_produk
            );
            $pemasukan->nominal = intval($pesanan->total_harga); // Convert to integer if stored as string
            $pemasukan->created_by = $pesanan->created_by;
            $pemasukan->created_at = now();
            $pemasukan->save();

            DB::commit();

            return redirect()->route('pesanans.index')
                ->with('success', 'Order marked as paid and transaction recorded successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            
            return redirect()->route('pesanans.index')
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
                return redirect()->route('pesanans.index')
                    ->with('error', 'Invalid status transition. Order must be paid first.');
            }

            $pesanan->status_pesanan = 'completed';
            $pesanan->save();

            DB::commit();

            return redirect()->route('pesanans.index')
                ->with('success', 'Order marked as completed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pesanans.index')
                ->with('error', 'Failed to complete order: ' . $e->getMessage());
        }
    }

    public function destroyWithPemasukan($id)
    {
        try {
            DB::beginTransaction();

            $pesanan = Pesanan::findOrFail($id);

            // Delete associated pemasukan
            Pemasukan::where('id_referensi', $pesanan->id_pesanan)->delete();

            // Delete the pesanan
            $pesanan->delete();

            DB::commit();

            return redirect()->route('pesanans.index')
                ->with('success', 'Pesanan and associated pemasukan deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('pesanans.index')
                ->with('error', 'Failed to delete pesanan: ' . $e->getMessage());
        }
    }
}
