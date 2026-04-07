<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edukasi Gizi & Imunisasi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-10 text-center">
                        <h3 class="text-3xl font-bold text-gray-800 mb-2">Pusat Edukasi Kesehatan</h3>
                        <p class="text-gray-600 max-w-2xl mx-auto">Informasi penting mengenai tumbuh kembang anak, pemenuhan gizi seimbang, dan jadwal imunisasi wajib.</p>
                    </div>

                    <div class="space-y-12">
                        <!-- Edukasi Gizi Section -->
                        <section>
                            <div class="flex items-center mb-4">
                                <div class="bg-orange-100 p-2 rounded-lg text-orange-600 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-semibold text-gray-800">Gizi Seimbang Balita</h4>
                            </div>
                            <div class="bg-orange-50 rounded-xl p-6 shadow-sm border border-orange-100">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h5 class="font-bold text-orange-800 mb-2">Pemberian Makan Bayi & Anak (PMBA)</h5>
                                        <ul class="space-y-2 text-sm text-gray-700 list-disc list-inside">
                                            <li><strong>0-6 Bulan:</strong> ASI Eksklusif saja tanpa tambahan air/makanan lain.</li>
                                            <li><strong>6-9 Bulan:</strong> ASI + MPASI lumat (puree/bubur saring), 2-3x sehari.</li>
                                            <li><strong>9-12 Bulan:</strong> ASI + MPASI cincang lunak/nasi tim, 3-4x sehari.</li>
                                            <li><strong>12-24 Bulan:</strong> ASI + Makanan keluarga (nasi biasa), 3-4x sehari.</li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h5 class="font-bold text-orange-800 mb-2">Isi Piringku</h5>
                                        <p class="text-sm text-gray-700 mb-2">Pastikan MPASI mengandung 4 Kuadran gizi lengkap:</p>
                                        <ul class="space-y-1 text-sm text-gray-700 list-disc list-inside">
                                            <li>Karbohidrat (Nasi, kentang, jagung)</li>
                                            <li>Protein Hewani (Telur, hati ayam, ikan, daging) - <strong>Sangat penting cegah stunting!</strong></li>
                                            <li>Kacang-kacangan (Tahu, tempe)</li>
                                            <li>Sayur & Buah sedikit untuk pengenalan tekstur.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Imunisasi Section -->
                        <section>
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-100 p-2 rounded-lg text-blue-600 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <h4 class="text-2xl font-semibold text-gray-800">Jadwal Imunisasi Wajib</h4>
                            </div>
                            <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usia Bayi</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Imunisasi Dasar</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pencegahan Penyakit</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 text-sm">
                                        <tr>
                                            <td class="px-6 py-4 font-medium text-gray-900">0 Bulan</td>
                                            <td class="px-6 py-4 text-indigo-600 font-semibold">Hepatitis B0</td>
                                            <td class="px-6 py-4 text-gray-600">Hepatitis B (Liver)</td>
                                        </tr>
                                        <tr class="bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">1 Bulan</td>
                                            <td class="px-6 py-4 text-indigo-600 font-semibold">BCG, Polio 1</td>
                                            <td class="px-6 py-4 text-gray-600">TBC dan Polio</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 font-medium text-gray-900">2 Bulan</td>
                                            <td class="px-6 py-4 text-indigo-600 font-semibold">DPT-HB-Hib 1, Polio 2, PCV 1</td>
                                            <td class="px-6 py-4 text-gray-600">Difteri, Pertusis, Tetanus, Radang Paru</td>
                                        </tr>
                                        <tr class="bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">3 Bulan</td>
                                            <td class="px-6 py-4 text-indigo-600 font-semibold">DPT-HB-Hib 2, Polio 3, PCV 2</td>
                                            <td class="px-6 py-4 text-gray-600">-</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 font-medium text-gray-900">4 Bulan</td>
                                            <td class="px-6 py-4 text-indigo-600 font-semibold">DPT-HB-Hib 3, Polio 4, IPV</td>
                                            <td class="px-6 py-4 text-gray-600">-</td>
                                        </tr>
                                        <tr class="bg-gray-50">
                                            <td class="px-6 py-4 font-medium text-gray-900">9 Bulan</td>
                                            <td class="px-6 py-4 text-indigo-600 font-semibold">Campak / MR</td>
                                            <td class="px-6 py-4 text-gray-600">Campak & Rubella</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
