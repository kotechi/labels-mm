<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Pengeluaran;
use App\Models\Pemasukan;
use App\Models\Pesanan;
use App\Models\tbl_transaksi;

class ReportController extends Controller
{
    public function generatePDF(Request $request)
    {
        // Get base64 chart image
        $chartImage = $this->generateChartImage();
        
        $data = [
            'totalPengeluaran' => $this->getTotalPengeluaran(),
            'totalPemasukan' => $this->getTotalPemasukan(),
            'totalPenghasilan' => $this->getTotalPenghasilan(),
            'pesanans' => $this->getPesananData(),
            'transaksis' => $this->getTransaksiData(),
            'monthlyData' => $this->getMonthlyData(),
            'periode' => Carbon::now()->format('F Y'),
            'chartImage' => $chartImage // Add chart image to data
        ];

        $pdf = PDF::loadView('reports.financial-report', $data);
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('laporan-keuangan-' . Carbon::now()->format('Y-m-d') . '.pdf');
    }

    private function generateChartImage()
    {
        $monthlyData = $this->getMonthlyData();
        
        // Prepare data arrays
        $months = [];
        $pemasukan = [];
        $pengeluaran = [];
        
        foreach ($monthlyData as $data) {
            $months[] = Carbon::create()->month($data->month)->format('F');
            $pemasukan[] = $data->pemasukan;
            $pengeluaran[] = $data->pengeluaran;
        }
        
        // Create chart using Chart.js
        $chartHtml = view('reports.chart', compact('months', 'pemasukan', 'pengeluaran'))->render();
        
        // Use Node.js and Puppeteer to convert chart to image (you'll need to set this up)
        // This is a simplified example - you'll need to implement the actual conversion
        $chartImage = shell_exec("node chart-generator.js '" . base64_encode($chartHtml) . "'");
        
        return $chartImage;
    }

    private function getTotalPengeluaran()
    {
        return tbl_transaksi::where('kategori', 'pengeluaran')
            ->sum('nominal') ?? 0; // Added return and null coalescing operator
    }

    private function getTotalPemasukan()
    {
        return tbl_transaksi::where('kategori', 'pemasukan')
            ->sum('nominal') ?? 0; // Added return and null coalescing operator
    }

    private function getTotalPenghasilan()
    {
        return $this->getTotalPemasukan() - $this->getTotalPengeluaran();
    }

    private function getPesananData()
    {
        return Pesanan::with('user')
            ->latest()
            ->take(10)
            ->get() ?? collect([]); // Added return and empty collection fallback
    }

    private function getTransaksiData()
    {
        return tbl_transaksi::with('user')
            ->latest()
            ->take(10)
            ->get() ?? collect([]); // Added return and empty collection fallback
    }

    private function getMonthlyData()
    {
        return tbl_transaksi::selectRaw('MONTH(tanggal) as month')
            ->selectRaw('SUM(CASE WHEN kategori = "pemasukan" THEN nominal ELSE 0 END) as pemasukan')
            ->selectRaw('SUM(CASE WHEN kategori = "pengeluaran" THEN nominal ELSE 0 END) as pengeluaran')
            ->whereYear('tanggal', Carbon::now()->year)
            ->groupBy('month')
            ->get() ?? collect([]); // Added return and empty collection fallback
    }
}