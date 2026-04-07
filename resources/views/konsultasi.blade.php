<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konsultasi Kesehatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="text-center md:text-left md:flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Layanan Konsultasi Online</h3>
                            <p class="text-gray-600">Hubungi Bidan atau Kader Posyandu Bontolohe untuk pertanyaan seputar kesehatan Ibu dan Anak.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Contact Card 1 -->
                        <div class="bg-green-50 rounded-lg p-6 border border-green-100 shadow-sm flex items-start space-x-4">
                            <div class="bg-green-500 rounded-full p-3 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-gray-800">Bidan Posyandu</h4>
                                <p class="text-gray-600 text-sm mb-3">Konsultasi medis, kehamilan, dan tumbuh kembang anak.</p>
                                <a href="https://wa.me/6281234567890" target="_blank" class="inline-flex items-center bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-md transition duration-150 ease-in-out text-sm">
                                    Hubungi Bidan via WhatsApp
                                </a>
                            </div>
                        </div>

                        <!-- Contact Card 2 -->
                        <div class="bg-blue-50 rounded-lg p-6 border border-blue-100 shadow-sm flex items-start space-x-4">
                            <div class="bg-blue-500 rounded-full p-3 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-gray-800">Kader Posyandu</h4>
                                <p class="text-gray-600 text-sm mb-3">Informasi jadwal Posyandu, bantuan administrasi, dan gizi dasar.</p>
                                <a href="https://wa.me/6289876543210" target="_blank" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md transition duration-150 ease-in-out text-sm">
                                    Hubungi Kader via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 bg-gray-50 p-6 rounded-lg text-sm text-gray-600">
                        <p class="font-semibold text-gray-800 mb-2">Waktu Operasional Konsultasi:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Senin - Jumat: 08:00 - 15:00 WITA</li>
                            <li>Kondisi darurat: Silakan langsung menuju Puskesmas terdekat.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
