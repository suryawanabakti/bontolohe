<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $targets = \App\Models\PosyanduTarget::where('tahun', date('Y'))->get();
        return view('reports.index', compact('targets'));
    }

    public function storeTarget(Request $request)
    {
        $validated = $request->validate([
            'sasaran_bumil' => 'required|integer|min:0',
            'tahun' => 'required|integer',
        ]);

        \App\Models\PosyanduTarget::updateOrCreate(
            ['kader_id' => auth()->id(), 'tahun' => $validated['tahun']],
            ['sasaran_bumil' => $validated['sasaran_bumil']]
        );

        return back()->with('success', 'Target berhasil disimpan.');
    }

    public function patientReport(Request $request)
    {
        $query = Patient::whereIn('kategori', ['balita', 'ibu_hamil', 'ibu_nifas']);
        if (auth()->user()->hasRole('kader_posyandu')) {
            $query->where('kader_id', auth()->id());
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $patients = $query->orderBy('nama')->get();
        $filters = $request->only(['kategori', 'jenis_kelamin', 'search']);

        $pdf = Pdf::loadView('reports.patients_pdf', compact('patients', 'filters'));
        return $pdf->download('laporan_pasien.pdf');
    }

    public function examinationReport(Request $request)
    {
        $query = Examination::with('patient')->whereHas('patient', function ($q) {
            $q->whereIn('kategori', ['balita', 'ibu_hamil', 'ibu_nifas']);
        });
        if (auth()->user()->hasRole('kader_posyandu')) {
            $query->whereHas('patient', function ($q) {
                $q->where('kader_id', auth()->id());
            });
        }

        if ($request->filled('kategori')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('kategori', $request->kategori);
            });
        }
        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_pemeriksaan', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_pemeriksaan', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        $examinations = $query->latest('tanggal_pemeriksaan')->get();
        $filters = $request->only(['kategori', 'tanggal_dari', 'tanggal_sampai', 'patient_id']);

        $pdf = Pdf::loadView('reports.examinations_pdf', compact('examinations', 'filters'));
        return $pdf->download('laporan_pemeriksaan.pdf');
    }

    public function posyanduMonthlyReport(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $date = \Carbon\Carbon::createFromDate($tahun, $bulan, 1);

        // Fetch all balita patients
        $query = Patient::where('kategori', 'balita');
        if (auth()->user()->hasRole('kader_posyandu')) {
            $query->where('kader_id', auth()->id());
        }
        $patients = $query->get();

        $rows = [
            '0-5' => ['label' => '0 - 5 Bulan', 'L' => $this->emptyMetrics(), 'P' => $this->emptyMetrics()],
            '6-11' => ['label' => '6 - 11 Bulan', 'L' => $this->emptyMetrics(), 'P' => $this->emptyMetrics()],
            '12-23' => ['label' => '12 - 23 Bulan', 'L' => $this->emptyMetrics(), 'P' => $this->emptyMetrics()],
            '24-59' => ['label' => '24 - 59 Bulan', 'L' => $this->emptyMetrics(), 'P' => $this->emptyMetrics()],
        ];

        foreach ($patients as $patient) {
            // Calculate age in months at the report month
            $ageInMonths = \Carbon\Carbon::parse($patient->tanggal_lahir)->diffInMonths($date);
            
            $ageGroup = null;
            if ($ageInMonths <= 5) $ageGroup = '0-5';
            elseif ($ageInMonths <= 11) $ageGroup = '6-11';
            elseif ($ageInMonths <= 23) $ageGroup = '12-23';
            elseif ($ageInMonths <= 59) $ageGroup = '24-59';

            if ($ageGroup) {
                $gender = $patient->jenis_kelamin;
                $rows[$ageGroup][$gender]['S']++;
                if ($patient->has_kms) {
                    $rows[$ageGroup][$gender]['K']++;
                }

                // Check examination for this month
                $exam = Examination::where('patient_id', $patient->id)
                    ->whereMonth('tanggal_pemeriksaan', $bulan)
                    ->whereYear('tanggal_pemeriksaan', $tahun)
                    ->first();

                if ($exam) {
                    $rows[$ageGroup][$gender]['D']++;
                    if ($exam->naik_berat_badan) $rows[$ageGroup][$gender]['N']++;
                    if ($exam->bgm) $rows[$ageGroup][$gender]['BGM']++;
                    if ($exam->vitamin_a) $rows[$ageGroup][$gender]['VitA']++;
                }
            }
        }

        $pdf = Pdf::loadView('reports.posyandu_bulanan_pdf', compact('rows', 'bulan', 'tahun'))->setPaper('a4', 'landscape');
        return $pdf->download("laporan_bulanan_posyandu_{$bulan}_{$tahun}.pdf");
    }

    public function stuntingReport(Request $request)
    {
        $bulan = $request->query('bulan', date('n'));
        $tahun = $request->query('tahun', date('Y'));
        
        $dateLimit = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        // Subquery for the latest examination of each patient before/on dateLimit
        $latestExams = Examination::select('patient_id', \DB::raw('MAX(tanggal_pemeriksaan) as max_date'))
            ->where('tanggal_pemeriksaan', '<=', $dateLimit)
            ->groupBy('patient_id');

        $data = Patient::where('kategori', 'balita')
            ->leftJoinSub($latestExams, 'latest_exams', function ($join) {
                $join->on('patients.id', '=', 'latest_exams.patient_id');
            })
            ->leftJoin('examinations', function ($join) {
                $join->on('patients.id', '=', 'examinations.patient_id')
                    ->on('examinations.tanggal_pemeriksaan', '=', 'latest_exams.max_date');
            })
            ->select('patients.*', 'examinations.berat_badan', 'examinations.tinggi_badan', 'examinations.naik_berat_badan', 'examinations.bgm', 'examinations.status_stunting', 'examinations.asupan_gizi', 'examinations.imunisasi_gizi')
            ->orderBy('patients.nama')
            ->get();

        $bulan_nama = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->format('F');

        $pdf = Pdf::loadView('reports.stunting_pdf', [
            'data' => $data,
            'bulan_nama' => $bulan_nama,
            'tahun' => $tahun
        ]);

        return $pdf->download("Laporan_Stunting_{$bulan_nama}_{$tahun}.pdf");
    }

    public function pregnantReport(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $kaderId = auth()->id();
        $isAdmin = auth()->user()->hasRole('admin');

        // Target
        $targetQuery = \App\Models\PosyanduTarget::where('tahun', $tahun);
        if (!$isAdmin) {
            $targetQuery->where('kader_id', $kaderId);
        }
        $sasaranBumil = $targetQuery->sum('sasaran_bumil');

        // Patients
        $patientsQuery = Patient::query();
        if (!$isAdmin) {
            $patientsQuery->where('kader_id', $kaderId);
        }
        $patients = $patientsQuery->whereIn('kategori', ['ibu_hamil', 'ibu_nifas'])->get();

        $metrics = [
            'nifas_fe_40' => 0,
            'bumil_ttd_1' => 0,
            'bumil_ttd_3' => 0,
            'bumil_kek' => 0,
        ];

        foreach ($patients as $patient) {
            $dateLimit = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();
            $totalFe = Examination::where('patient_id', $patient->id)
                ->where('tanggal_pemeriksaan', '<=', $dateLimit)
                ->sum('tablet_fe');

            if ($patient->kategori === 'ibu_nifas' && $totalFe >= 40) {
                $metrics['nifas_fe_40']++;
            }

            if ($patient->kategori === 'ibu_hamil') {
                if ($totalFe >= 30) $metrics['bumil_ttd_1']++;
                if ($totalFe >= 90) $metrics['bumil_ttd_3']++;
                
                $hasKek = Examination::where('patient_id', $patient->id)
                    ->where('tanggal_pemeriksaan', '<=', $dateLimit)
                    ->where('is_kek', true)
                    ->exists();
                if ($hasKek) $metrics['bumil_kek']++;
            }
        }

        $pdf = Pdf::loadView('reports.pregnant_pdf', compact('metrics', 'sasaranBumil', 'bulan', 'tahun'));
        return $pdf->download("laporan_bumil_nifas_{$bulan}_{$tahun}.pdf");
    }

    private function emptyMetrics()

    {
        return ['S' => 0, 'K' => 0, 'D' => 0, 'N' => 0, 'BGM' => 0, 'VitA' => 0];
    }
}
