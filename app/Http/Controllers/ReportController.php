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

    private function generateChartBase64(array $labels, array $pemasukan, array $pengeluaran, string $title = '')
    {
        $keuntungan = array_map(function ($in, $out) {
            return $in - $out;
        }, $pemasukan, $pengeluaran);
    
        // Hitung total
        $totalPemasukan = array_sum($pemasukan);
        $totalPengeluaran = array_sum($pengeluaran);
        $totalKeuntungan = array_sum($keuntungan);
    
        $chartConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Pemasukan (Rp ' . number_format($totalPemasukan, 0, ',', '.') . ')',
                        'data' => $pemasukan,
                        'borderColor' => '#003cff',
                        'fill' => false,
                        'tension' => 0.3,
                        'pointRadius' => 4,
                    ],
                    [
                        'label' => 'Pengeluaran (Rp ' . number_format($totalPengeluaran, 0, ',', '.') . ')',
                        'data' => $pengeluaran,
                        'borderColor' => '#ff0000',
                        'fill' => false,
                        'tension' => 0.3,
                        'pointRadius' => 4,
                    ],
                    [
                        'label' => 'Total Keuntungan (Rp ' . number_format($totalKeuntungan, 0, ',', '.') . ')',
                        'data' => $keuntungan,
                        'borderColor' => '#15ff00',
                        'fill' => false,
                        'tension' => 0.3,
                        'pointRadius' => 4,
                    ],
                ]
            ],
        ];
    
        $url = 'https://quickchart.io/chart?c=' . urlencode(json_encode($chartConfig));
        $imageData = file_get_contents($url);
        return 'data:image/png;base64,' . base64_encode($imageData);
    }
    
    
    


    public function generatePDF(Request $request)
    {
        // Get report type from request
        $reportType = $request->input('type', 'current');
        $selectedYear = $request->input('year', Carbon::now()->year);
        $selectedMonth = $request->input('month', Carbon::now()->month);
        
        // Create date objects for filtering
        $reportDate = Carbon::create($selectedYear, $reportType === 'yearly' ? 1 : $selectedMonth);
        
        // Generate appropriate chart image based on report type
        $chartImage = $reportType === 'yearly' 
            ? $this->generateYearlyChartImage($selectedYear)
            : $this->generateMonthlyChartImage($selectedYear, $selectedMonth);
        
        // Get the data based on the report type
        $data = [
            'totalPengeluaran' => $this->getTotalPengeluaran($reportType, $selectedYear, $selectedMonth),
            'totalPemasukan' => $this->getTotalPemasukan($reportType, $selectedYear, $selectedMonth),
            'totalPenghasilan' => $this->getTotalPenghasilan($reportType, $selectedYear, $selectedMonth),
            'pesanans' => $this->getPesananData($reportType, $selectedYear, $selectedMonth),
            'transaksis' => $this->getTransaksiData($reportType, $selectedYear, $selectedMonth),
            'chartImage' => $chartImage,
            'reportType' => $reportType,
            'reportTitle' => $this->getReportTitle($reportType, $reportDate)
        ];
        
        // Add specific data based on report type
        if ($reportType === 'yearly') {
            $data['monthlyData'] = $this->getMonthlyDataForYear($selectedYear);
            $data['yearlyCharts'] = $this->getMonthlyCharts($selectedYear);
        } else {
            $data['dailyData'] = $this->getDailyDataForMonth($selectedYear, $selectedMonth);
        }
        
        $pdf = PDF::loadView('reports.financial-report', $data);
        $pdf->setPaper('a4', 'portrait');
        
        $filename = 'laporan-keuangan-';
        $filename .= $reportType === 'yearly' 
            ? $selectedYear 
            : Carbon::create($selectedYear, $selectedMonth)->format('Y-m');
        $filename .= '.pdf'; 
        
        return $pdf->download($filename);
    }
    
    private function getReportTitle($reportType, $reportDate)
    {
        if ($reportType === 'yearly') {
            return 'Laporan Keuangan Tahunan ' . $reportDate->year;
        } else {
            return 'Laporan Keuangan Bulanan ' . $reportDate->format('F Y');
        }
    }

    private function generateYearlyChartImage($year)
    {
        $monthlyData = $this->getMonthlyDataForYear($year);
    
        $labels = $monthlyData->pluck('month')->map(function($m) {
            return Carbon::create()->month($m)->format('M');
        })->toArray();
    
        $pemasukan = $monthlyData->pluck('pemasukan')->toArray();
        $pengeluaran = $monthlyData->pluck('pengeluaran')->toArray();
    
        return $this->generateChartBase64($labels, $pemasukan, $pengeluaran, "Grafik Tahunan {$year}");
    }
    
    
    private function generateMonthlyChartImage($year, $month)
    {
        $dailyData = $this->getDailyDataForMonth($year, $month);
    
        $labels = $dailyData->pluck('day')->toArray();
        $pemasukan = $dailyData->pluck('pemasukan')->toArray();
        $pengeluaran = $dailyData->pluck('pengeluaran')->toArray();
    
        return $this->generateChartBase64($labels, $pemasukan, $pengeluaran, "Grafik Harian {$year}-" . str_pad($month, 2, '0', STR_PAD_LEFT));
    }

    
    private function getMonthlyCharts($year)
    {
        $charts = [];
        
        // For each month, generate a daily chart
        for ($month = 1; $month <= 12; $month++) {
            $monthName = Carbon::create($year, $month)->format('F');
            $charts[$month] = [
                'name' => $monthName,
                'chart' => $this->generateMonthlyChartImage($year, $month)
            ];
        }
        
        return $charts;
    }

    private function getTotalPengeluaran($reportType, $year, $month = null)
    {
        $query = tbl_transaksi::where('kategori', 'pengeluaran');
        
        if ($reportType === 'yearly') {
            $query->whereYear('tanggal', $year);
        } else {
            $query->whereYear('tanggal', $year)
                  ->whereMonth('tanggal', $month);
        }
        
        return $query->sum('nominal') ?? 0;
    }

    private function getTotalPemasukan($reportType, $year, $month = null)
    {
        $query = tbl_transaksi::where('kategori', 'pemasukan');
        
        if ($reportType === 'yearly') {
            $query->whereYear('tanggal', $year);
        } else {
            $query->whereYear('tanggal', $year)
                  ->whereMonth('tanggal', $month);
        }
        
        return $query->sum('nominal') ?? 0;
    }

    private function getTotalPenghasilan($reportType, $year, $month = null)
    {
        return $this->getTotalPemasukan($reportType, $year, $month) - 
               $this->getTotalPengeluaran($reportType, $year, $month);
    }

    private function getPesananData($reportType, $year, $month = null)
    {
        $query = Pesanan::with('user');
        
        if ($reportType === 'yearly') {
            $query->whereYear('created_at', $year);
        } else {
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }
        
        return $query->latest()->get() ?? collect([]);
    }

    private function getTransaksiData($reportType, $year, $month = null)
    {
        $query = tbl_transaksi::with('user');
        
        if ($reportType === 'yearly') {
            $query->whereYear('tanggal', $year);
        } else {
            $query->whereYear('tanggal', $year)
                  ->whereMonth('tanggal', $month);
        }
        
        return $query->latest()->get() ?? collect([]);
    }

    private function getMonthlyDataForYear($year)
    {
        // Get actual data from database
        $actualData = tbl_transaksi::selectRaw('MONTH(tanggal) as month')
            ->selectRaw('SUM(CASE WHEN kategori = "pemasukan" THEN nominal ELSE 0 END) as pemasukan')
            ->selectRaw('SUM(CASE WHEN kategori = "pengeluaran" THEN nominal ELSE 0 END) as pengeluaran')
            ->selectRaw('SUM(CASE WHEN kategori = "pemasukan" THEN nominal ELSE 0 END) - 
                         SUM(CASE WHEN kategori = "pengeluaran" THEN nominal ELSE 0 END) as keuntungan')
            ->whereYear('tanggal', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');
        
        // Create a collection with all 12 months
        $allMonths = collect();
        for ($month = 1; $month <= 12; $month++) {
            $monthData = $actualData->get($month) ?? [
                'month' => $month,
                'pemasukan' => 0,
                'pengeluaran' => 0,
                'keuntungan' => 0
            ];
            
            $allMonths->push($monthData);
        }
        
        return $allMonths;
    }
    
    private function getDailyDataForMonth($year, $month)
    {
        // Get the number of days in the month
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        
        // Get actual data from database
        $actualData = tbl_transaksi::selectRaw('DAY(tanggal) as day')
            ->selectRaw('SUM(CASE WHEN kategori = "pemasukan" THEN nominal ELSE 0 END) as pemasukan')
            ->selectRaw('SUM(CASE WHEN kategori = "pengeluaran" THEN nominal ELSE 0 END) as pengeluaran')
            ->selectRaw('SUM(CASE WHEN kategori = "pemasukan" THEN nominal ELSE 0 END) - 
                         SUM(CASE WHEN kategori = "pengeluaran" THEN nominal ELSE 0 END) as keuntungan')
            ->whereYear('tanggal', $year)
            ->whereMonth('tanggal', $month)
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');
        
        // Create a collection with all days in the month
        $allDays = collect();
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $dayData = $actualData->get($day) ?? [
                'day' => $day,
                'pemasukan' => 0,
                'pengeluaran' => 0,
                'keuntungan' => 0
            ];
            
            $allDays->push($dayData);
        }
        
        return $allDays;
    }
}