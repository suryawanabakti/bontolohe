<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Kader Posyandu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Statistik --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Pasien</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalPatients }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Pemeriksaan Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $examsToday }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Pemeriksaan Bulan Ini</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $examsThisMonth }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aksi Cepat --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('patients.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                            Tambah Pasien Baru
                        </a>
                        <a href="{{ route('examinations.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Input Pemeriksaan
                        </a>
                        <a href="{{ route('patients.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                            Daftar Pasien
                        </a>
                        <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-md transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Laporan
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Distribusi Kategori --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Kategori Pasien</h3>
                        @php $total = max(array_sum($categoryDistribution), 1); @endphp
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-600">Balita</span>
                                    <span class="text-gray-800 font-bold">{{ $categoryDistribution['balita'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-500 h-3 rounded-full" style="width: {{ ($categoryDistribution['balita'] / $total) * 100 }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-600">Ibu Hamil</span>
                                    <span class="text-gray-800 font-bold">{{ $categoryDistribution['ibu_hamil'] }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-pink-500 h-3 rounded-full" style="width: {{ ($categoryDistribution['ibu_hamil'] / $total) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Belum Diperiksa Bulan Ini --}}
                        @if($patientsNeedingCheckup->isNotEmpty())
                            <h3 class="text-lg font-semibold text-gray-800 mt-6 mb-3">Belum Diperiksa Bulan Ini</h3>
                            <div class="space-y-2">
                                @foreach($patientsNeedingCheckup as $patient)
                                    <div class="flex justify-between items-center py-2 px-3 bg-red-50 rounded-lg border border-red-100">
                                        <span class="text-sm font-medium text-gray-700">{{ $patient->nama }}</span>
                                        <span class="text-xs text-red-600 font-semibold">{{ ucwords(str_replace('_', ' ', $patient->kategori)) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Pemeriksaan Terakhir --}}
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">Pemeriksaan Terakhir</h3>
                            <a href="{{ route('examinations.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua →</a>
                        </div>
                        @if($recentExaminations->isEmpty())
                            <p class="text-gray-500 text-sm italic">Belum ada data pemeriksaan.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase text-xs">Pasien</th>
                                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase text-xs">Kategori</th>
                                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase text-xs">Tanggal</th>
                                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase text-xs">BB (kg)</th>
                                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase text-xs">Status</th>
                                            <th class="px-4 py-3 text-left font-medium text-gray-500 uppercase text-xs">TB (cm)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($recentExaminations as $exam)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-4 py-3 font-medium text-gray-900">{{ $exam->patient->nama ?? '-' }}</td>
                                                <td class="px-4 py-3">
                                                    @php
                                                        $badgeColor = match($exam->patient->kategori ?? '') {
                                                            'balita' => 'bg-blue-100 text-blue-700',
                                                            'ibu_hamil' => 'bg-pink-100 text-pink-700',
                                                            default => 'bg-gray-100 text-gray-700',
                                                        };
                                                    @endphp
                                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $badgeColor }}">
                                                        {{ ucwords(str_replace('_', ' ', $exam->patient->kategori ?? '-')) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($exam->tanggal_pemeriksaan)->format('d M Y') }}</td>
                                                <td class="px-4 py-3 text-gray-600 font-bold">{{ $exam->berat_badan ?? '-' }}</td>
                                                <td class="px-4 py-3">
                                                    <div class="flex gap-1">
                                                        @if($exam->naik_berat_badan) <span class="text-[10px] font-bold bg-green-100 text-green-700 px-1 rounded">N</span> @endif
                                                        @if($exam->bgm) <span class="text-[10px] font-bold bg-red-100 text-red-700 px-1 rounded">BGM</span> @endif
                                                        @if($exam->vitamin_a) <span class="text-[10px] font-bold bg-orange-100 text-orange-700 px-1 rounded">VIT A</span> @endif
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-gray-600">{{ $exam->tinggi_badan ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
