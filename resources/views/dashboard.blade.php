<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(isset($myPatients))
                @if($myPatients->isEmpty())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 text-center">
                            <p class="text-gray-500">Belum ada data pasien yang ditautkan ke akun Anda.</p>
                            <p class="text-sm mt-2">Silakan hubungi Kader Posyandu untuk menautkan data.</p>
                        </div>
                    </div>
                @else
                    @foreach($myPatients as $patient)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 text-gray-900">
                                <div class="flex items-center justify-between mb-4 pb-4 border-b">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $patient->nama }}</h3>
                                        <p class="text-sm text-gray-500">
                                            Kategori: <span class="font-semibold text-indigo-600">{{ ucwords(str_replace('_', ' ', $patient->kategori)) }}</span> | 
                                            Lahir: {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <h4 class="font-semibold text-md mb-3 text-gray-700">Riwayat Pemeriksaan Terakhir</h4>
                                
                                @if($patient->examinations->isEmpty())
                                    <p class="text-sm text-gray-500 italic">Belum ada riwayat pemeriksaan.</p>
                                @else
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Tanggal</th>
                                                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">BB (kg)</th>
                                                    <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">TB (cm)</th>
                                                    @if($patient->kategori == 'balita')
                                                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">L. Kepala (cm)</th>
                                                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">LILA (cm)</th>
                                                    @elseif($patient->kategori == 'ibu_hamil')
                                                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">TFU (cm)</th>
                                                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">DJJ (bpm)</th>
                                                    @elseif($patient->kategori == 'lansia')
                                                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Tensi</th>
                                                        <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Suhu (°C)</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($patient->examinations as $exam)
                                                    <tr>
                                                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($exam->tanggal_pemeriksaan)->format('d M Y') }}</td>
                                                        <td class="px-4 py-2">{{ $exam->berat_badan ?? '-' }}</td>
                                                        <td class="px-4 py-2">{{ $exam->tinggi_badan ?? '-' }}</td>
                                                        @if($patient->kategori == 'balita')
                                                            <td class="px-4 py-2">{{ $exam->lingkar_kepala ?? '-' }}</td>
                                                            <td class="px-4 py-2">{{ $exam->lila ?? '-' }}</td>
                                                        @elseif($patient->kategori == 'ibu_hamil')
                                                            <td class="px-4 py-2">{{ $exam->tfu ?? '-' }}</td>
                                                            <td class="px-4 py-2">{{ $exam->djj ?? '-' }}</td>
                                                        @elseif($patient->kategori == 'lansia')
                                                            <td class="px-4 py-2">{{ $exam->tekanan_darah ?? '-' }}</td>
                                                            <td class="px-4 py-2">{{ $exam->suhu ?? '-' }}</td>
                                                        @endif
                                                    </tr>
                                                    @if($exam->catatan)
                                                    <tr>
                                                        <td colspan="10" class="px-4 py-2 text-xs text-gray-600 bg-gray-50">
                                                            <strong>Catatan:</strong> {{ $exam->catatan }}
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-xl font-bold mb-2">Selamat Datang di Sistem Informasi Posyandu Bontolohe</h3>
                        <p class="text-gray-600">Anda masuk sebagai pengguna sistem. Gunakan menu navigasi di atas untuk mengelola data Posyandu.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
