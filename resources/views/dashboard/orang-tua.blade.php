<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard Orang Tua') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Welcome --}}
            <div class="bg-gradient-to-r from-blue-500 to-cyan-500 shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-1">Halo, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-blue-100">Pantau tumbuh kembang anak Anda di sini.</p>
                    @if($lastExam)
                        <div class="mt-3 bg-white/20 rounded-lg p-3 backdrop-blur-sm">
                            <p class="text-sm"><strong>Pemeriksaan terakhir:</strong> {{ \Carbon\Carbon::parse($lastExam->tanggal_pemeriksaan)->format('d M Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($myPatients->isEmpty())
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-500 font-medium">Belum ada data anak yang ditautkan ke akun Anda.</p>
                        <p class="text-sm text-gray-400 mt-1">Silakan hubungi Kader Posyandu untuk menautkan data.</p>
                    </div>
                </div>
            @else
                @foreach($myPatients as $patient)
                    @php 
                        $latestExam = $patient->examinations->first(); 
                        $catBadge = match($patient->kategori) {
                            'balita' => 'bg-blue-100 text-blue-700',
                            'ibu_hamil' => 'bg-pink-100 text-pink-700',
                            'lansia' => 'bg-amber-100 text-amber-700',
                            default => 'bg-gray-100 text-gray-700',
                        };
                    @endphp
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4 pb-4 border-b">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $patient->nama }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Lahir: {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->format('d M Y') }}
                                        ({{ \Carbon\Carbon::parse($patient->tanggal_lahir)->age }} tahun)
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="px-3 py-1 {{ $catBadge }} rounded-full text-sm font-semibold">{{ ucwords(str_replace('_', ' ', $patient->kategori)) }}</span>
                                    @if($patient->has_kms)
                                        <span class="px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-xs font-bold border border-indigo-200">KMS ✓</span>
                                    @endif
                                </div>
                            </div>

                            @if($latestExam)
                                <h4 class="font-semibold text-gray-700 mb-3">Data Terakhir</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                                    <div class="bg-blue-50 rounded-lg p-4 text-center border border-blue-100">
                                        <p class="text-xs text-blue-600 font-medium uppercase">Berat Badan</p>
                                        <p class="text-2xl font-bold text-blue-700 mt-1">{{ $latestExam->berat_badan ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">kg</p>
                                    </div>
                                    <div class="bg-green-50 rounded-lg p-4 text-center border border-green-100">
                                        <p class="text-xs text-green-600 font-medium uppercase">Tinggi Badan</p>
                                        <p class="text-2xl font-bold text-green-700 mt-1">{{ $latestExam->tinggi_badan ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">cm</p>
                                    </div>
                                    <div class="bg-purple-50 rounded-lg p-4 text-center border border-purple-100">
                                        <p class="text-xs text-purple-600 font-medium uppercase">Lingkar Kepala</p>
                                        <p class="text-2xl font-bold text-purple-700 mt-1">{{ $latestExam->lingkar_kepala ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">cm</p>
                                    </div>
                                    <div class="bg-orange-50 rounded-lg p-4 text-center border border-orange-100">
                                        <p class="text-xs text-orange-600 font-medium uppercase">LILA</p>
                                        <p class="text-2xl font-bold text-orange-700 mt-1">{{ $latestExam->lila ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">cm</p>
                                    </div>
                                </div>

                                {{-- Grafik Perkembangan --}}
                                @if($patient->examinations->count() >= 2)
                                    <div class="mb-6">
                                        <h4 class="font-semibold text-gray-700 mb-3">Grafik Perkembangan</h4>
                                        <div class="bg-white border border-gray-200 rounded-lg p-4">
                                            <canvas id="growthChart-{{ $patient->id }}" height="250"></canvas>
                                        </div>
                                    </div>
                                    @push('scripts')
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                const chartData = @json($patient->chartData);
                                                if (chartData.labels.length >= 2) {
                                                    window.createGrowthChart('growthChart-{{ $patient->id }}', chartData);
                                                }
                                            });
                                        </script>
                                    @endpush
                                @endif

                                {{-- Health Status Badges --}}
                                <div class="flex flex-wrap gap-2 mb-6">
                                    @if($latestExam->naik_berat_badan)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            BB Naik (N)
                                        </span>
                                    @endif
                                    @if($latestExam->bgm)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Bawah Garis Merah (BGM)
                                        </span>
                                    @endif
                                    @if($latestExam->vitamin_a)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            Sudah Vitamin A
                                        </span>
                                    @endif
                                </div>
                                @if($latestExam->catatan)
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                                        <p class="text-sm text-yellow-800"><strong>Catatan:</strong> {{ $latestExam->catatan }}</p>
                                    </div>
                                @endif
                            @endif

                            <h4 class="font-semibold text-gray-700 mb-3">Riwayat Pemeriksaan</h4>
                            @if($patient->examinations->isEmpty())
                                <p class="text-sm text-gray-500 italic">Belum ada riwayat.</p>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">BB (kg)</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status BB</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">BGM</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">TB (cm)</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">L. Kepala</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">LILA</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($patient->examinations as $exam)
                                                <tr class="hover:bg-gray-50">
                                                     <td class="px-4 py-2">{{ \Carbon\Carbon::parse($exam->tanggal_pemeriksaan)->format('d M Y') }}</td>
                                                     <td class="px-4 py-2 font-bold">{{ $exam->berat_badan ?? '-' }}</td>
                                                     <td class="px-4 py-2">
                                                         @if($exam->naik_berat_badan)
                                                             <span class="text-green-600 font-bold">N</span>
                                                         @else
                                                             <span class="text-red-500 font-bold">T</span>
                                                         @endif
                                                     </td>
                                                     <td class="px-4 py-2">
                                                         {!! $exam->bgm ? '<span class="text-red-600 font-bold">BGM</span>' : '-' !!}
                                                     </td>
                                                     <td class="px-4 py-2">{{ $exam->tinggi_badan ?? '-' }}</td>
                                                    <td class="px-4 py-2">{{ $exam->lingkar_kepala ?? '-' }}</td>
                                                    <td class="px-4 py-2">{{ $exam->lila ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Quick Links --}}
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Menu Lainnya</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('konsultasi') }}" class="flex items-center p-4 bg-green-50 rounded-lg border border-green-100 hover:bg-green-100 transition-colors">
                            <div class="p-2 bg-green-500 rounded-lg text-white mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Konsultasi</p>
                                <p class="text-sm text-gray-500">Hubungi Bidan atau Kader</p>
                            </div>
                        </a>
                        <a href="{{ route('edukasi') }}" class="flex items-center p-4 bg-blue-50 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors">
                            <div class="p-2 bg-blue-500 rounded-lg text-white mr-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Edukasi</p>
                                <p class="text-sm text-gray-500">Info gizi & imunisasi</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
