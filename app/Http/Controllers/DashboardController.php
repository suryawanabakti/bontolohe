<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return $this->adminDashboard();
        }

        if ($user->hasRole('kader_posyandu')) {
            return $this->kaderDashboard();
        }

        if ($user->hasRole('ibu_hamil')) {
            return $this->ibuHamilDashboard($user);
        }

        if ($user->hasRole('orang_tua')) {
            return $this->orangTuaDashboard($user);
        }

        // Fallback
        return view('dashboard', ['myPatients' => collect()]);
    }

    private function adminDashboard()
    {
        $totalPatients = Patient::count();
        $totalExaminations = Examination::count();
        $totalUsers = User::count();
        $examsThisMonth = Examination::whereMonth('tanggal_pemeriksaan', Carbon::now()->month)
            ->whereYear('tanggal_pemeriksaan', Carbon::now()->year)
            ->count();

        $categoryDistribution = [
            'balita' => Patient::where('kategori', 'balita')->count(),
            'ibu_hamil' => Patient::where('kategori', 'ibu_hamil')->count(),
        ];

        $recentExaminations = Examination::with('patient')
            ->latest('tanggal_pemeriksaan')
            ->take(5)
            ->get();

        $usersPerRole = [
            'admin' => User::role('admin')->count(),
            'kader_posyandu' => User::role('kader_posyandu')->count(),
            'ibu_hamil' => User::role('ibu_hamil')->count(),
            'orang_tua' => User::role('orang_tua')->count(),
        ];

        $chartData = $this->getMonthlyChartData();

        return view('dashboard.admin', compact(
            'totalPatients',
            'totalExaminations',
            'totalUsers',
            'examsThisMonth',
            'categoryDistribution',
            'recentExaminations',
            'usersPerRole',
            'chartData'
        ));
    }

    private function getMonthlyChartData()
    {
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('m');
            $year = $date->format('Y');
            $label = $date->format('M Y');

            $data['labels'][] = $label;
            $data['examsCount'][] = Examination::whereMonth('tanggal_pemeriksaan', $month)
                ->whereYear('tanggal_pemeriksaan', $year)
                ->count();

            $data['avgBb'][] = round((float) (Examination::whereMonth('tanggal_pemeriksaan', $month)
                ->whereYear('tanggal_pemeriksaan', $year)
                ->whereNotNull('berat_badan')
                ->avg('berat_badan') ?? 0), 1);

            $data['avgTb'][] = round((float) (Examination::whereMonth('tanggal_pemeriksaan', $month)
                ->whereYear('tanggal_pemeriksaan', $year)
                ->whereNotNull('tinggi_badan')
                ->avg('tinggi_badan') ?? 0), 1);
        }
        return $data;
    }

    private function kaderDashboard()
    {
        $kaderId = auth()->id();
        $totalPatients = Patient::where('kader_id', $kaderId)->count();
        $examsToday = Examination::where('kader_id', $kaderId)->whereDate('tanggal_pemeriksaan', Carbon::today())->count();
        $examsThisMonth = Examination::where('kader_id', $kaderId)
            ->whereMonth('tanggal_pemeriksaan', Carbon::now()->month)
            ->whereYear('tanggal_pemeriksaan', Carbon::now()->year)
            ->count();

        $categoryDistribution = [
            'balita' => Patient::where('kader_id', $kaderId)->where('kategori', 'balita')->count(),
            'ibu_hamil' => Patient::where('kader_id', $kaderId)->where('kategori', 'ibu_hamil')->count(),
        ];

        $recentExaminations = Examination::where('kader_id', $kaderId)
            ->with('patient')
            ->latest('tanggal_pemeriksaan')
            ->take(5)
            ->get();

        $patientsNeedingCheckup = Patient::where('kader_id', $kaderId)
            ->whereDoesntHave('examinations', function ($q) {
                $q->whereMonth('tanggal_pemeriksaan', Carbon::now()->month)
                  ->whereYear('tanggal_pemeriksaan', Carbon::now()->year);
            })->take(5)->get();

        // Chart data: monthly examination trend (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->format('m');
            $year = $date->format('Y');
            $label = $date->format('M Y');

            $count = Examination::where('kader_id', $kaderId)
                ->whereMonth('tanggal_pemeriksaan', $month)
                ->whereYear('tanggal_pemeriksaan', $year)
                ->count();

            $avgBb = Examination::where('kader_id', $kaderId)
                ->whereMonth('tanggal_pemeriksaan', $month)
                ->whereYear('tanggal_pemeriksaan', $year)
                ->whereNotNull('berat_badan')
                ->avg('berat_badan');

            $avgTb = Examination::where('kader_id', $kaderId)
                ->whereMonth('tanggal_pemeriksaan', $month)
                ->whereYear('tanggal_pemeriksaan', $year)
                ->whereNotNull('tinggi_badan')
                ->avg('tinggi_badan');

            $monthlyData[] = [
                'label' => $label,
                'count' => $count,
                'avgBb' => round((float) ($avgBb ?? 0), 1),
                'avgTb' => round((float) ($avgTb ?? 0), 1),
            ];
        }

        $chartLabels = array_column($monthlyData, 'label');
        $chartCounts = array_column($monthlyData, 'count');
        $chartAvgBb = array_column($monthlyData, 'avgBb');
        $chartAvgTb = array_column($monthlyData, 'avgTb');

        return view('dashboard.kader', compact(
            'totalPatients',
            'examsToday',
            'examsThisMonth',
            'categoryDistribution',
            'recentExaminations',
            'patientsNeedingCheckup',
            'chartLabels',
            'chartCounts',
            'chartAvgBb',
            'chartAvgTb'
        ));
    }

    private function ibuHamilDashboard(User $user)
    {
        $myPatients = Patient::where('user_id', $user->id)
            ->with(['examinations' => function ($query) {
                $query->latest('tanggal_pemeriksaan');
            }])
            ->get();

        $lastExam = null;
        if ($myPatients->isNotEmpty()) {
            $lastExam = Examination::whereIn('patient_id', $myPatients->pluck('id'))
                ->latest('tanggal_pemeriksaan')
                ->first();
        }

        return view('dashboard.ibu-hamil', compact('myPatients', 'lastExam'));
    }

    private function orangTuaDashboard(User $user)
    {
        $myPatients = Patient::where('user_id', $user->id)
            ->with(['examinations' => function ($query) {
                $query->latest('tanggal_pemeriksaan');
            }])
            ->get()
            ->map(function ($patient) {
                $exams = $patient->examinations->reverse()->values();
                $chartData = [
                    'labels' => $exams->map(fn($e) => \Carbon\Carbon::parse($e->tanggal_pemeriksaan)->format('d M'))->toArray(),
                    'beratBadan' => $exams->map(fn($e) => (float) ($e->berat_badan ?? 0))->toArray(),
                    'tinggiBadan' => $exams->map(fn($e) => (float) ($e->tinggi_badan ?? 0))->toArray(),
                    'lingkarKepala' => $exams->map(fn($e) => (float) ($e->lingkar_kepala ?? 0))->toArray(),
                    'lila' => $exams->map(fn($e) => (float) ($e->lila ?? 0))->toArray(),
                ];
                $patient->chartData = $chartData;
                return $patient;
            });

        $lastExam = null;
        if ($myPatients->isNotEmpty()) {
            $lastExam = Examination::whereIn('patient_id', $myPatients->pluck('id'))
                ->latest('tanggal_pemeriksaan')
                ->first();
        }

        return view('dashboard.orang-tua', compact('myPatients', 'lastExam'));
    }
}
