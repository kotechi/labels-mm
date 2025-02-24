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

        $currentMonth = $request->input('month', date('m'));
        $currentYear = $request->input('year', date('Y'));
        $period = $request->input('period', 'monthly');

        $monthlyEarnings = [];
        $monthlyModal = [];
        $monthlyTotalPemasukan = [];
        $months = [];
        $dailyEarnings = [];
        $dailyModal = [];
        $dailyTotalPemasukan = [];
        $days = [];

        foreach (range(1, 12) as $month) {
            $monthlyPendapatan = Pemasukan::whereMonth('created_at', $month)->whereYear('created_at', $currentYear)->sum('nominal');
            $monthlyModalValue = Pengeluaran::whereMonth('created_at', $month)->whereYear('created_at', $currentYear)->sum('nominal_pengeluaran');
            $monthlyEarnings[] = $monthlyPendapatan;
            $monthlyModal[] = $monthlyModalValue;
            $monthlyTotalPemasukan[] = $monthlyPendapatan - $monthlyModalValue;
            $months[] = date('F', mktime(0, 0, 0, $month, 10));
        }

        foreach (range(1, 31) as $day) {
            $dailyPendapatan = Pemasukan::whereDay('created_at', $day)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('nominal');
            $dailyModalValue = Pengeluaran::whereDay('created_at', $day)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('nominal_pengeluaran');
            $dailyEarnings[] = $dailyPendapatan;
            $dailyModal[] = $dailyModalValue;
            $dailyTotalPemasukan[] = $dailyPendapatan - $dailyModalValue;
            $days[] = $day;
        }

        $yearlyEarnings = [];
        $yearlyModal = [];
        $yearlyTotalPemasukan = [];
        $years = [];

        foreach (range(date('Y') - 5, date('Y')) as $year) {
            $yearlyPendapatan = Pemasukan::whereYear('created_at', $year)->sum('nominal');
            $yearlyModalValue = Pengeluaran::whereYear('created_at', $year)->sum('nominal_pengeluaran');
            $yearlyEarnings[] = $yearlyPendapatan;
            $yearlyModal[] = $yearlyModalValue;
            $yearlyTotalPemasukan[] = $yearlyPendapatan - $yearlyModalValue;
            $years[] = $year;
        }

        $totalMonthlyEarnings = array_sum($monthlyTotalPemasukan);
        $totalDailyEarnings = array_sum($dailyTotalPemasukan);
        $totalYearlyEarnings = array_sum($yearlyTotalPemasukan);

        $totalPengeluaran = Pengeluaran::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('nominal_pengeluaran');
        $totalPemasukan = Pemasukan::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('nominal');
        $totalPenghasilan = $totalPemasukan - $totalPengeluaran;

        if ($request->ajax()) {
            if ($period === 'daily') {
                return response()->json([
                    'labels' => $days,
                    'data' => [
                        'pendapatan' => $dailyEarnings,
                        'modal' => $dailyModal,
                        'totalPemasukan' => $dailyTotalPemasukan
                    ],
                    'label' => "Daily Earnings for $currentMonth/$currentYear",
                    'totalEarnings' => $totalDailyEarnings
                ]);
            } elseif ($period === 'monthly') {
                return response()->json([
                    'labels' => $months,
                    'data' => [
                        'pendapatan' => $monthlyEarnings,
                        'modal' => $monthlyModal,
                        'totalPemasukan' => $monthlyTotalPemasukan
                    ],
                    'label' => "Monthly Earnings for $currentYear",
                    'totalEarnings' => $totalMonthlyEarnings
                ]);
            } elseif ($period === 'yearly') {
                return response()->json([
                    'labels' => $years,
                    'data' => [
                        'pendapatan' => $yearlyEarnings,
                        'modal' => $yearlyModal,
                        'totalPemasukan' => $yearlyTotalPemasukan
                    ],
                    'label' => 'Yearly Earnings',
                    'totalEarnings' => $totalYearlyEarnings
                ]);
            }
        }

        return view('admin.index', compact(
            'transaksis', 'pesanans', 'pengeluaran', 'pemasukan', 'monthlyEarnings', 'monthlyModal', 
            'monthlyTotalPemasukan', 'months', 'dailyEarnings', 'dailyModal', 'dailyTotalPemasukan', 
            'days', 'yearlyEarnings', 'yearlyModal', 'yearlyTotalPemasukan', 'years', 'totalMonthlyEarnings', 
            'totalDailyEarnings', 'totalYearlyEarnings', 'currentMonth', 'currentYear', 'totalPengeluaran', 
            'totalPemasukan', 'totalPenghasilan'
        ));
    }

    public function getDailyEarnings()
    {
        $dailyEarnings = [];
        $days = [];

        foreach (range(1, 31) as $day) {
            $dailyPendapatan = Pemasukan::whereDay('created_at', $day)->sum('nominal');
            $dailyModal = Pengeluaran::whereDay('created_at', $day)->sum('nominal_pengeluaran');
            $dailyEarnings[] = $dailyPendapatan - $dailyModal;
            $days[] = $day;
        }

        return view('admin.index', compact('dailyEarnings', 'days'));
    }

    public function getYearlyEarnings()
    {
        $yearlyEarnings = [];
        $years = [];

        foreach (range(date('Y') - 5, date('Y')) as $year) {
            $yearlyPendapatan = Pemasukan::whereYear('created_at', $year)->sum('nominal');
            $yearlyModal = Pengeluaran::whereYear('created_at', $year)->sum('nominal_pengeluaran');
            $yearlyEarnings[] = $yearlyPendapatan - $yearlyModal;
            $years[] = $year;
        }

        return view('admin.index', compact('yearlyEarnings', 'years'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
