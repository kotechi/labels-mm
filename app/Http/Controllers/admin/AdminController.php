<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Modal;
use App\Models\Penghasilan;
use App\Models\Pesanan;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $modal = Modal::all();
        $penghasilan = Penghasilan::all();
        $pesanans = Pesanan::all();

        $currentMonth = $request->input('month', date('m'));
        $currentYear = $request->input('year', date('Y'));
        $period = $request->input('period', 'monthly');

        $monthlyEarnings = [];
        $monthlyModal = [];
        $monthlyTotalPenghasilan = [];
        $months = [];
        $dailyEarnings = [];
        $dailyModal = [];
        $dailyTotalPenghasilan = [];
        $days = [];

        foreach (range(1, 12) as $month) {
            $monthlyPendapatan = Penghasilan::whereMonth('created_at', $month)->whereYear('created_at', $currentYear)->sum('harga');
            $monthlyModalValue = Modal::whereMonth('created_at', $month)->whereYear('created_at', $currentYear)->sum('harga');
            $monthlyEarnings[] = $monthlyPendapatan;
            $monthlyModal[] = $monthlyModalValue;
            $monthlyTotalPenghasilan[] = $monthlyPendapatan - $monthlyModalValue;
            $months[] = date('F', mktime(0, 0, 0, $month, 10));
        }

        foreach (range(1, 31) as $day) {
            $dailyPendapatan = Penghasilan::whereDay('created_at', $day)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('harga');
            $dailyModalValue = Modal::whereDay('created_at', $day)->whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->sum('harga');
            $dailyEarnings[] = $dailyPendapatan;
            $dailyModal[] = $dailyModalValue;
            $dailyTotalPenghasilan[] = $dailyPendapatan - $dailyModalValue;
            $days[] = $day;
        }

        $yearlyEarnings = [];
        $yearlyModal = [];
        $yearlyTotalPenghasilan = [];
        $years = [];

        foreach (range(date('Y') - 5, date('Y')) as $year) {
            $yearlyPendapatan = Penghasilan::whereYear('created_at', $year)->sum('harga');
            $yearlyModalValue = Modal::whereYear('created_at', $year)->sum('harga');
            $yearlyEarnings[] = $yearlyPendapatan;
            $yearlyModal[] = $yearlyModalValue;
            $yearlyTotalPenghasilan[] = $yearlyPendapatan - $yearlyModalValue;
            $years[] = $year;
        }

        $totalMonthlyEarnings = array_sum($monthlyTotalPenghasilan);
        $totalDailyEarnings = array_sum($dailyTotalPenghasilan);
        $totalYearlyEarnings = array_sum($yearlyTotalPenghasilan);

        if ($request->ajax()) {
            if ($period === 'daily') {
                return response()->json([
                    'labels' => $days,
                    'data' => [
                        'pendapatan' => $dailyEarnings,
                        'modal' => $dailyModal,
                        'totalPenghasilan' => $dailyTotalPenghasilan
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
                        'totalPenghasilan' => $monthlyTotalPenghasilan
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
                        'totalPenghasilan' => $yearlyTotalPenghasilan
                    ],
                    'label' => 'Yearly Earnings',
                    'totalEarnings' => $totalYearlyEarnings
                ]);
            }
        }

        return view('admin.index', compact('pesanans','modal', 'penghasilan', 'monthlyEarnings', 'monthlyModal', 'monthlyTotalPenghasilan', 'months', 'dailyEarnings', 'dailyModal', 'dailyTotalPenghasilan', 'days', 'yearlyEarnings', 'yearlyModal', 'yearlyTotalPenghasilan', 'years', 'totalMonthlyEarnings', 'totalDailyEarnings', 'totalYearlyEarnings', 'currentMonth', 'currentYear'));
    }

    public function getDailyEarnings()
    {
        $dailyEarnings = [];
        $days = [];

        foreach (range(1, 31) as $day) {
            $dailyPendapatan = Penghasilan::whereDay('created_at', $day)->sum('harga');
            $dailyModal = Modal::whereDay('created_at', $day)->sum('harga');
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
            $yearlyPendapatan = Penghasilan::whereYear('created_at', $year)->sum('harga');
            $yearlyModal = Modal::whereYear('created_at', $year)->sum('harga');
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
