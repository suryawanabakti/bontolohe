<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Patient;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    private function checkOwnership(Examination $examination)
    {
        if (auth()->user()->hasRole('kader_posyandu') && $examination->kader_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data pemeriksaan ini.');
        }
    }

    public function index(Request $request)
    {
        $query = Examination::with('patient');

        if (auth()->user()->hasRole('kader_posyandu')) {
            $query->where('kader_id', auth()->id());
        }

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
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

        $examinations = $query->latest('tanggal_pemeriksaan')->paginate(10)->withQueryString();
        
        $patientQuery = Patient::orderBy('nama');
        if (auth()->user()->hasRole('kader_posyandu')) {
            $patientQuery->where('kader_id', auth()->id());
        }
        $patients = $patientQuery->get();

        return view('examinations.index', compact('examinations', 'patients'));
    }

    public function create()
    {
        $query = Patient::orderBy('nama');
        if (auth()->user()->hasRole('kader_posyandu')) {
            $query->where('kader_id', auth()->id());
        }
        $patients = $query->get();
        return view('examinations.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'lingkar_kepala' => 'nullable|numeric',
            'lila' => 'nullable|numeric',
            'tekanan_darah' => 'nullable|string|max:20',
            'suhu' => 'nullable|numeric',
            'tfu' => 'nullable|numeric',
            'djj' => 'nullable|integer',
            'catatan' => 'nullable|string',
            'tablet_fe' => 'nullable|integer',
            'is_kek' => 'nullable|boolean',
            'status_stunting' => 'nullable|string|max:255',
            'asupan_gizi' => 'nullable|string|max:255',
            'imunisasi_gizi' => 'nullable|string|max:255',
        ]);

        $data = $validated;
        $data['naik_berat_badan'] = $request->has('naik_berat_badan');
        $data['bgm'] = $request->has('bgm');
        $data['vitamin_a'] = $request->has('vitamin_a');
        $data['is_kek'] = $request->has('is_kek');
        $data['tablet_fe'] = $request->input('tablet_fe', 0);
        $data['kader_id'] = auth()->id();

        Examination::create($data);

        return redirect()->route('examinations.index')->with('success', 'Data pemeriksaan berhasil disimpan.');
    }

    public function edit(Examination $examination)
    {
        $this->checkOwnership($examination);
        $patients = Patient::all();
        return view('examinations.edit', compact('examination', 'patients'));
    }

    public function update(Request $request, Examination $examination)
    {
        $this->checkOwnership($examination);
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'nullable|numeric',
            'tinggi_badan' => 'nullable|numeric',
            'lingkar_kepala' => 'nullable|numeric',
            'lila' => 'nullable|numeric',
            'tekanan_darah' => 'nullable|string|max:20',
            'suhu' => 'nullable|numeric',
            'tfu' => 'nullable|numeric',
            'djj' => 'nullable|integer',
            'catatan' => 'nullable|string',
            'tablet_fe' => 'nullable|integer',
            'is_kek' => 'nullable|boolean',
            'status_stunting' => 'nullable|string|max:255',
            'asupan_gizi' => 'nullable|string|max:255',
            'imunisasi_gizi' => 'nullable|string|max:255',
        ]);

        $data = $validated;
        $data['naik_berat_badan'] = $request->has('naik_berat_badan');
        $data['bgm'] = $request->has('bgm');
        $data['vitamin_a'] = $request->has('vitamin_a');
        $data['is_kek'] = $request->has('is_kek');
        $data['tablet_fe'] = $request->input('tablet_fe', 0);

        $examination->update($data);

        return redirect()->route('examinations.index')->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }

    public function destroy(Examination $examination)
    {
        $this->checkOwnership($examination);
        $examination->delete();
        return redirect()->route('examinations.index')->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}
