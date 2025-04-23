<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use App\Models\Pemasukan;
use App\Models\Pesanan;
use App\Models\Contact;
use App\Models\tbl_transaksi;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $contact = Contact::all();
        $pengeluaran = Pengeluaran::all();
        $pemasukan = Pemasukan::all();
        $pesanans = Pesanan::all();
        $transaksis = tbl_transaksi::with('user')->get();

        $currentMonth = date('m');
        $currentYear = date('Y');
        
        $startYear = $currentYear - 5;
        
        // ======== DATA BULANAN UNTUK SEMUA TAHUN =========
        $allMonthlyData = [];
        
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $monthlyEarnings = [];
            $monthlyModal = [];
            $monthlyTotalPemasukan = [];
            $months = [];
            
            foreach (range(1, 12) as $month) {
                $pendapatan = Pemasukan::whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->sum('nominal');
                    
                $modal = Pengeluaran::whereMonth('created_at', $month)
                    ->whereYear('created_at', $year)
                    ->sum('nominal_pengeluaran');
                
                $monthlyEarnings[] = $pendapatan;
                $monthlyModal[] = $modal;
                $monthlyTotalPemasukan[] = $pendapatan - $modal;
                $months[] = date('F', mktime(0, 0, 0, $month, 10));
            }
            
            $totalMonthlyEarnings = array_sum($monthlyTotalPemasukan);
            
            $allMonthlyData[$year] = [
                'months' => $months,
                'pemasukan' => $monthlyEarnings,
                'pengeluaran' => $monthlyModal,
                'keuntungan' => $monthlyTotalPemasukan,
                'total' => $totalMonthlyEarnings
            ];
        }
        
        // ======== DATA HARIAN UNTUK SEMUA BULAN DAN TAHUN =========
        $allDailyData = [];
        
        // Loop through each year we want to track
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $allDailyData[$year] = [];
            
            // Loop through each month
            for ($month = 1; $month <= 12; $month++) {
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                
                $dailyEarnings = [];
                $dailyModal = [];
                $dailyTotalPemasukan = [];
                $dailyLabels = [];
                
                foreach (range(1, $daysInMonth) as $day) {
                    $pendapatan = Pemasukan::whereDay('created_at', $day)
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->sum('nominal');
                        
                    $modal = Pengeluaran::whereDay('created_at', $day)
                        ->whereMonth('created_at', $month)
                        ->whereYear('created_at', $year)
                        ->sum('nominal_pengeluaran');
                    
                    $dailyEarnings[] = $pendapatan;
                    $dailyModal[] = $modal;
                    $dailyTotalPemasukan[] = $pendapatan - $modal;
                    $dailyLabels[] = $day;
                }
                
                $totalDailyEarnings = array_sum($dailyTotalPemasukan);
                
                $allDailyData[$year][$month] = [
                    'days' => $dailyLabels,
                    'pemasukan' => $dailyEarnings,
                    'pengeluaran' => $dailyModal,
                    'keuntungan' => $dailyTotalPemasukan,
                    'total' => $totalDailyEarnings
                ];
            }
        }
        
        // ======== DATA TAHUNAN =========
        $yearlyEarnings = [];
        $yearlyModal = [];
        $yearlyTotalPemasukan = [];
        $years = [];
        
        foreach (range($startYear, $currentYear) as $year) {
            $pendapatan = Pemasukan::whereYear('created_at', $year)->sum('nominal');
            $modal = Pengeluaran::whereYear('created_at', $year)->sum('nominal_pengeluaran');
            
            $yearlyEarnings[] = $pendapatan;
            $yearlyModal[] = $modal;
            $yearlyTotalPemasukan[] = $pendapatan - $modal;
            $years[] = $year;
        }
        
        $yearlyData = [
            'years' => $years,
            'pemasukan' => $yearlyEarnings,
            'pengeluaran' => $yearlyModal,
            'keuntungan' => $yearlyTotalPemasukan,
            'total' => array_sum($yearlyTotalPemasukan)
        ];
        
        // ======== DATA UTAMA UNTUK TAMPILAN AWAL =========
        $totalPengeluaran = Pengeluaran::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('nominal_pengeluaran');
            
        $totalPemasukan = Pemasukan::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->sum('nominal');
            
        $totalPenghasilan = $totalPemasukan - $totalPengeluaran;
        
        return view('admin.index', compact(
            'transaksis', 'pesanans', 'pengeluaran', 'pemasukan',
            'allMonthlyData', 'allDailyData', 'yearlyData',
            'currentMonth', 'currentYear', 'startYear',
            'totalPengeluaran', 'totalPemasukan', 'totalPenghasilan', 'contact'
        ));
    }
}