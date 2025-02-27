<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\Pemasukan;
use App\Models\Pesanan;
use App\Models\tbl_transaksi;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $pengeluaran = Pengeluaran::all();
        $pemasukan = Pemasukan::all();
        $pesanans = Pesanan::all();
        $transaksis = tbl_transaksi::with('user')->get();

        $currentMonth = date('m');
        $currentYear = date('Y');

        // ======== DATA BULANAN =========
        $monthlyEarnings = [];
        $monthlyModal = [];
        $monthlyTotalPemasukan = [];
        $months = [];

        foreach (range(1, 12) as $month) {
            $pendapatan = Pemasukan::whereMonth('created_at', $month)->whereYear('created_at', $currentYear)->sum('nominal');
            $modal = Pengeluaran::whereMonth('created_at', $month)->whereYear('created_at', $currentYear)->sum('nominal_pengeluaran');
            
            $monthlyEarnings[] = $pendapatan;
            $monthlyModal[] = $modal;
            $monthlyTotalPemasukan[] = $pendapatan - $modal;
            $months[] = date('F', mktime(0, 0, 0, $month, 10));
        }

        // ======== DATA HARIAN =========
        $dailyEarnings = [];
        $dailyModal = [];
        $dailyTotalPemasukan = [];
        $dailyLabels = [];

        foreach (range(1, 31) as $day) {
            $pendapatan = Pemasukan::whereDay('created_at', $day)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('nominal');
            $modal = Pengeluaran::whereDay('created_at', $day)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('nominal_pengeluaran');
            
            $dailyEarnings[] = $pendapatan;
            $dailyModal[] = $modal;
            $dailyTotalPemasukan[] = $pendapatan - $modal;
            $dailyLabels[] = $day;
        }

        // ======== DATA TAHUNAN =========
        $yearlyEarnings = [];
        $yearlyModal = [];
        $yearlyTotalPemasukan = [];
        $years = [];

        foreach (range(date('Y') - 5, date('Y')) as $year) {
            $pendapatan = Pemasukan::whereYear('created_at', $year)->sum('nominal');
            $modal = Pengeluaran::whereYear('created_at', $year)->sum('nominal_pengeluaran');
            
            $yearlyEarnings[] = $pendapatan;
            $yearlyModal[] = $modal;
            $yearlyTotalPemasukan[] = $pendapatan - $modal;
            $years[] = $year;
        }

        // ======== TOTAL =========
        $totalMonthlyEarnings = array_sum($monthlyTotalPemasukan);
        $totalDailyEarnings = array_sum($dailyTotalPemasukan);
        $totalYearlyEarnings = array_sum($yearlyTotalPemasukan);

        $totalPengeluaran = Pengeluaran::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('nominal_pengeluaran');
        $totalPemasukan = Pemasukan::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('nominal');
        $totalPenghasilan = $totalPemasukan - $totalPengeluaran;

        return view('admin.index', compact(
            'transaksis', 'pesanans', 'pengeluaran', 'pemasukan',
            'monthlyEarnings', 'monthlyModal', 'monthlyTotalPemasukan', 'months',
            'dailyEarnings', 'dailyModal', 'dailyTotalPemasukan', 'dailyLabels',
            'yearlyEarnings', 'yearlyModal', 'yearlyTotalPemasukan', 'years',
            'totalMonthlyEarnings', 'totalDailyEarnings', 'totalYearlyEarnings',
            'totalPengeluaran', 'totalPemasukan', 'totalPenghasilan'
        ));
    }
}
