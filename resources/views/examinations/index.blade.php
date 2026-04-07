<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Riwayat Pemeriksaan') }}</h2>
            <a href="{{ route('examinations.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150">
                Tambah Pemeriksaan
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4">
                    <form method="GET" action="{{ route('examinations.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Cari Pasien</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama pasien..." class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
                            <select name="kategori" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua</option>
                                <option value="balita" {{ request('kategori') == 'balita' ? 'selected' : '' }}>Balita</option>
                                <option value="ibu_hamil" {{ request('kategori') == 'ibu_hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Dari Tanggal</label>
                            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full rounded-md border-gray-300 shadow-sm text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700 transition-colors">Filter</button>
                            <a href="{{ route('examinations.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-semibold rounded-md hover:bg-gray-300 transition-colors">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Periksa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">BB/TB</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($examinations as $exam)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $exam->patient->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ ucwords(str_replace('_', ' ', $exam->patient->kategori)) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($exam->tanggal_pemeriksaan)->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($exam->berat_badan) {{ $exam->berat_badan }}kg @endif
                                            @if($exam->tinggi_badan) / {{ $exam->tinggi_badan }}cm @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-xs text-gray-600">
                                                @if($exam->patient->kategori == 'balita')
                                                    LK: {{ $exam->lingkar_kepala ?? '-' }}cm, LILA: {{ $exam->lila ?? '-' }}cm
                                                @elseif($exam->patient->kategori == 'ibu_hamil')
                                                    TFU: {{ $exam->tfu ?? '-' }}cm, DJJ: {{ $exam->djj ?? '-' }}bpm
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('examinations.edit', $exam) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                            <form action="{{ route('examinations.destroy', $exam) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data pemeriksaan ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $examinations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
