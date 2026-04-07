<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pusat Laporan Posyandu') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Laporan Pasien --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Laporan Data Pasien</h3>
                            <p class="text-sm text-gray-500">Unduh daftar pasien berdasarkan filter yang dipilih.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('reports.patients') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Cari Nama</label>
                            <input type="text" name="search" placeholder="Nama pasien..." class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                            <select name="kategori" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Kategori</option>
                                <option value="balita">Balita</option>
                                <option value="ibu_hamil">Ibu Hamil</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 transition-colors">
                                Download PDF Pasien
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Laporan Pemeriksaan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Laporan Pemeriksaan</h3>
                            <p class="text-sm text-gray-500">Unduh riwayat pemeriksaan berdasarkan filter yang dipilih.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('reports.examinations') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pasien</label>
                            <select name="patient_id" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Pasien</option>
                                @foreach(\App\Models\Patient::orderBy('nama')->get() as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->nama }} ({{ ucwords(str_replace('_', ' ', $patient->kategori)) }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                            <select name="kategori" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Kategori</option>
                                <option value="balita">Balita</option>
                                <option value="ibu_hamil">Ibu Hamil</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="tanggal_dari" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="tanggal_sampai" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-md hover:bg-green-700 transition-colors">
                                Download PDF Pemeriksaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Pengaturan Sasaran --}}
            {{-- <div class="hidden bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Pengaturan Sasaran Ibu Hamil</h3>
                            <p class="text-sm text-gray-500">Set target jumlah ibu hamil untuk tahun {{ date('Y') }}.</p>
                        </div>
                    </div>
                    
                    @php
                        $currentTarget = $targets->where('kader_id', auth()->id())->first();
                    @endphp

                    <form method="POST" action="{{ route('reports.target.store') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end max-w-2xl">
                        @csrf
                        <input type="hidden" name="tahun" value="{{ date('Y') }}">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Sasaran Ibu Hamil (Orang)</label>
                            <x-text-input type="number" name="sasaran_bumil" :value="$currentTarget ? $currentTarget->sasaran_bumil : 0" required class="w-full text-sm" />
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 transition-colors">
                                Simpan Target {{ date('Y') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div> --}}

            {{-- Laporan Stunting Balita --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-l-4 border-blue-500">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Laporan Stunting Balita</h3>
                            <p class="text-sm text-gray-500">Unduh data status gizi, asupan, dan imunisasi balita.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('reports.stunting') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end max-w-2xl">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Bulan</label>
                            <select name="bulan" required class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Tahun</label>
                            <select name="tahun" required class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                                @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-md hover:bg-blue-700 transition-colors">
                                Download Laporan Stunting
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Laporan Ibu Hamil & Nifas --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-l-4 border-pink-500">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Laporan Ibu Hamil & Nifas</h3>
                            <p class="text-sm text-gray-500">Unduh data cakupan TTD (FE), KEK, dan Sasaran Ibu Hamil.</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('reports.pregnant') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end max-w-2xl">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Bulan</label>
                            <select name="bulan" required class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-pink-500 focus:border-pink-500">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Tahun</label>
                            <select name="tahun" required class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-pink-500 focus:border-pink-500">
                                @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-pink-600 text-white text-sm font-semibold rounded-md hover:bg-pink-700 transition-colors">
                                Download Laporan Bumil/Nifas
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Laporan Bulanan (SIP) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-l-4 border-orange-500">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Laporan Bulanan Posyandu (SIP)</h3>
                            <p class="text-sm text-gray-500">Laporan cross-tabulasi bulanan balita (S, K, D, N, BGM, Vit A).</p>
                        </div>
                    </div>
                    <form method="GET" action="{{ route('reports.monthly') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end max-w-2xl">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Bulan</label>
                            <select name="bulan" required class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-orange-500 focus:border-orange-500">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Tahun</label>
                            <select name="tahun" required class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-orange-500 focus:border-orange-500">
                                @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-orange-600 text-white text-sm font-semibold rounded-md hover:bg-orange-700 transition-colors">
                                Download Laporan SIP
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
