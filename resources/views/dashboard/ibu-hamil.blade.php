<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Dashboard Ibu Hamil') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Welcome --}}
            <div class="bg-gradient-to-r from-pink-500 to-rose-500 shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <h3 class="text-2xl font-bold mb-1">Halo, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-pink-100">Pantau perkembangan kesehatan kehamilan Anda.</p>
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
                        <p class="text-gray-500 font-medium">Belum ada data kesehatan yang ditautkan ke akun Anda.</p>
                        <p class="text-sm text-gray-400 mt-1">Silakan hubungi Kader Posyandu untuk menautkan data.</p>
                    </div>
                </div>
            @else
                @foreach($myPatients as $patient)
                    @php $latestExam = $patient->examinations->first(); @endphp
                    <div class="bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4 pb-4 border-b">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $patient->nama }}</h3>
                                    <p class="text-sm text-gray-500">Lahir: {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->format('d M Y') }}</p>
                                </div>
                                <span class="px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm font-semibold">Ibu Hamil</span>
                            </div>

                            @if($latestExam)
                                <h4 class="font-semibold text-gray-700 mb-3">Data Terakhir</h4>
                                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4 mb-6">
                                    <div class="bg-pink-50 rounded-lg p-4 text-center border border-pink-100">
                                        <p class="text-xs text-pink-600 font-medium uppercase">Berat Badan</p>
                                        <p class="text-2xl font-bold text-pink-700 mt-1">{{ $latestExam->berat_badan ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">kg</p>
                                    </div>
                                    <div class="bg-rose-50 rounded-lg p-4 text-center border border-rose-100">
                                        <p class="text-xs text-rose-600 font-medium uppercase">LILA</p>
                                        <p class="text-2xl font-bold text-rose-700 mt-1">{{ $latestExam->lila ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">cm</p>
                                    </div>
                                    <div class="bg-purple-50 rounded-lg p-4 text-center border border-purple-100">
                                        <p class="text-xs text-purple-600 font-medium uppercase">TFU</p>
                                        <p class="text-2xl font-bold text-purple-700 mt-1">{{ $latestExam->tfu ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">cm</p>
                                    </div>
                                    <div class="bg-red-50 rounded-lg p-4 text-center border border-red-100">
                                        <p class="text-xs text-red-600 font-medium uppercase">DJJ</p>
                                        <p class="text-2xl font-bold text-red-700 mt-1">{{ $latestExam->djj ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">bpm</p>
                                    </div>
                                    <div class="bg-indigo-50 rounded-lg p-4 text-center border border-indigo-100">
                                        <p class="text-xs text-indigo-600 font-medium uppercase">Umur Kehamilan</p>
                                        <p class="text-2xl font-bold text-indigo-700 mt-1">{{ $latestExam->umur_kehamilan ?? '-' }}</p>
                                        <p class="text-xs text-gray-500">minggu</p>
                                    </div>
                                    <div class="bg-teal-50 rounded-lg p-4 text-center border border-teal-100">
                                        <p class="text-xs text-teal-600 font-medium uppercase">HPL</p>
                                        <p class="text-lg font-bold text-teal-700 mt-1">{{ $latestExam->hpl ? \Carbon\Carbon::parse($latestExam->hpl)->format('d/m/Y') : '-' }}</p>
                                        <p class="text-xs text-gray-500">Perkiraan Lahir</p>
                                    </div>
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
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">UK</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">BB</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">LILA</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">TFU</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">DJJ</th>
                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tensi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                            @foreach($patient->examinations as $exam)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($exam->tanggal_pemeriksaan)->format('d M Y') }}</td>
                                                    <td class="px-4 py-2">{{ $exam->umur_kehamilan ? $exam->umur_kehamilan . ' mg' : '-' }}</td>
                                                    <td class="px-4 py-2">{{ $exam->berat_badan ?? '-' }}</td>
                                                    <td class="px-4 py-2">{{ $exam->lila ?? '-' }}</td>
                                                    <td class="px-4 py-2">{{ $exam->tfu ?? '-' }}</td>
                                                    <td class="px-4 py-2">{{ $exam->djj ?? '-' }}</td>
                                                    <td class="px-4 py-2">{{ $exam->tekanan_darah ?? '-' }}</td>
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
