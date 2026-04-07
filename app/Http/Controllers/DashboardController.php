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

        return view('dashboard.admin', compact(
            'totalPatients',
            'totalExaminations',
            'totalUsers',
            'examsThisMonth',
            'categoryDistribution',
            'recentExaminations',
            'usersPerRole'
        ));
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

        return view('dashboard.kader', compact(
            'totalPatients',
            'examsToday',
            'examsThisMonth',
            'categoryDistribution',
            'recentExaminations',
            'patientsNeedingCheckup'
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
            ->get();

        $lastExam = null;
        if ($myPatients->isNotEmpty()) {
            $lastExam = Examination::whereIn('patient_id', $myPatients->pluck('id'))
                ->latest('tanggal_pemeriksaan')
                ->first();
        }

        return view('dashboard.orang-tua', compact('myPatients', 'lastExam'));
    }
}
