<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private function checkOwnership(Patient $patient)
    {
        if (auth()->user()->hasRole('kader_posyandu') && $patient->kader_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data pasien ini.');
        }
    }

    public function index(Request $request)
    {
        $query = Patient::with(['user', 'latestExamination']);

        if (auth()->user()->hasRole('kader_posyandu')) {
            $query->where('kader_id', auth()->id());
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('umur_dari') || $request->filled('umur_sampai')) {
            $now = now();
            if ($request->filled('umur_sampai')) {
                $query->where('tanggal_lahir', '>=', $now->copy()->subYears($request->umur_sampai + 1)->addDay());
            }
            if ($request->filled('umur_dari')) {
                $query->where('tanggal_lahir', '<=', $now->copy()->subYears($request->umur_dari));
            }
        }

        $patients = $query->oldest('nama')->paginate(10)->withQueryString();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $users = User::role(['ibu_hamil', 'orang_tua'])->get();
        return view('patients.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'new_user_name' => 'nullable|string|max:255',
            'new_user_email' => 'nullable|string|email|max:255|unique:users,email',
            'new_user_password' => 'nullable|string|min:8',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'kategori' => 'required|in:balita,ibu_hamil,ibu_nifas',
            'has_kms' => 'nullable|boolean',
        ]);

        if (!empty($validated['new_user_name']) && !empty($validated['new_user_email']) && !empty($validated['new_user_password'])) {
            $user = User::create([
                'name' => $validated['new_user_name'],
                'email' => $validated['new_user_email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['new_user_password']),
            ]);

            $role = (in_array($validated['kategori'], ['ibu_hamil', 'ibu_nifas'])) ? 'ibu_hamil' : 'orang_tua';
            $user->assignRole($role);

            $validated['user_id'] = $user->id;
        }

        Patient::create([
            'user_id' => $validated['user_id'] ?? null,
            'kader_id' => auth()->id(),
            'nama' => $validated['nama'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'kategori' => $validated['kategori'],
            'has_kms' => $request->has('has_kms'),
        ]);

        return redirect()->route('patients.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit(Patient $patient)
    {
        $this->checkOwnership($patient);
        $users = User::all();
        return view('patients.edit', compact('patient', 'users'));
    }

    public function update(Request $request, Patient $patient)
    {
        $this->checkOwnership($patient);
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'new_user_name' => 'nullable|string|max:255',
            'new_user_email' => 'nullable|string|email|max:255|unique:users,email',
            'new_user_password' => 'nullable|string|min:8',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'kategori' => 'required|in:balita,ibu_hamil,ibu_nifas',
            'has_kms' => 'nullable|boolean',
        ]);

        if (!empty($validated['new_user_name']) && !empty($validated['new_user_email']) && !empty($validated['new_user_password'])) {
            $user = User::create([
                'name' => $validated['new_user_name'],
                'email' => $validated['new_user_email'],
                'password' => \Illuminate\Support\Facades\Hash::make($validated['new_user_password']),
            ]);

            $role = (in_array($validated['kategori'], ['ibu_hamil', 'ibu_nifas'])) ? 'ibu_hamil' : 'orang_tua';
            $user->assignRole($role);

            $validated['user_id'] = $user->id;
        }

        $patient->update([
            'user_id' => $validated['user_id'] ?? $patient->user_id,
            'nama' => $validated['nama'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'kategori' => $validated['kategori'],
            'has_kms' => $request->has('has_kms'),
        ]);

        return redirect()->route('patients.index')->with('success', 'Pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $this->checkOwnership($patient);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Pasien berhasil dihapus.');
    }
}
