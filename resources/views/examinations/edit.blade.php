<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Pemeriksaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('examinations.update', $examination) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="patient_id" :value="__('Pasien')" />
                                <select id="patient_id" name="patient_id"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id', $examination->patient_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->nama }} ({{ ucfirst($patient->kategori) }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('patient_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_pemeriksaan" :value="__('Tanggal Pemeriksaan')" />
                                <x-text-input id="tanggal_pemeriksaan" class="block mt-1 w-full" type="date"
                                    name="tanggal_pemeriksaan" :value="old('tanggal_pemeriksaan', $examination->tanggal_pemeriksaan)" required />
                                <x-input-error :messages="$errors->get('tanggal_pemeriksaan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="berat_badan" :value="__('Berat Badan (kg)')" />
                                <x-text-input id="berat_badan" class="block mt-1 w-full" type="number" step="0.01"
                                    name="berat_badan" :value="old('berat_badan', $examination->berat_badan)" />
                            </div>

                            <div>
                                <x-input-label for="tinggi_badan" :value="__('Tinggi Badan (cm)')" />
                                <x-text-input id="tinggi_badan" class="block mt-1 w-full" type="number" step="0.01"
                                    name="tinggi_badan" :value="old('tinggi_badan', $examination->tinggi_badan)" />
                            </div>

                            <div class="border-t pt-4 mt-2 md:col-span-2">
                                <h3 class="text-sm font-medium text-gray-700 mb-4">Data Khusus sesuai Kategori (Update)
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <p class="text-xs font-bold text-blue-800 mb-3 uppercase">Khusus Balita</p>
                                        <div class="space-y-4">
                                            <div>
                                                <x-input-label for="lingkar_kepala" :value="__('Lingkar Kepala (cm)')" />
                                                <x-text-input id="lingkar_kepala" class="block mt-1 w-full bg-white"
                                                    type="number" step="0.01" name="lingkar_kepala"
                                                    :value="old('lingkar_kepala', $examination->lingkar_kepala)" />
                                            </div>
                                            <div>
                                                <x-input-label for="lila" :value="__('LILA (cm)')" />
                                                <x-text-input id="lila" class="block mt-1 w-full bg-white"
                                                    type="number" step="0.01" name="lila" :value="old('lila', $examination->lila)" />
                                            </div>
                                            <div class="pt-2 border-t border-blue-200">
                                                <div class="flex items-center">
                                                    <input id="naik_berat_badan" type="checkbox" name="naik_berat_badan"
                                                        value="1"
                                                        {{ old('naik_berat_badan', $examination->naik_berat_badan) ? 'checked' : '' }}
                                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                                    <label for="naik_berat_badan"
                                                        class="ms-2 text-sm text-gray-700">{{ __('Berat Badan Naik (N)') }}</label>
                                                </div>
                                                <div class="flex items-center mt-2">
                                                    <input id="bgm" type="checkbox" name="bgm" value="1"
                                                        {{ old('bgm', $examination->bgm) ? 'checked' : '' }}
                                                        class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                                                    <label for="bgm"
                                                        class="ms-2 text-sm text-gray-700">{{ __('Bawah Garis Merah (BGM)') }}</label>
                                                </div>
                                                <div class="flex items-center mt-2">
                                                    <input id="vitamin_a" type="checkbox" name="vitamin_a"
                                                        value="1"
                                                        {{ old('vitamin_a', $examination->vitamin_a) ? 'checked' : '' }}
                                                        class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500">
                                                    <label for="vitamin_a"
                                                        class="ms-2 text-sm text-gray-700">{{ __('Dapat Vitamin A') }}</label>
                                                </div>
                                            </div>
                                            <div class="pt-2 border-t border-blue-200 space-y-3">
                                                <div>
                                                    <x-input-label for="status_stunting" :value="__('Status Stunting')" />
                                                    <select id="status_stunting" name="status_stunting"
                                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm bg-white">
                                                        <option value="">-- Pilih Status --</option>
                                                        <option value="Normal"
                                                            {{ old('status_stunting', $examination->status_stunting) == 'Normal' ? 'selected' : '' }}>
                                                            Normal</option>
                                                        <option value="Stunted"
                                                            {{ old('status_stunting', $examination->status_stunting) == 'Stunted' ? 'selected' : '' }}>
                                                            Stunted (Pendek)</option>
                                                        <option value="Severely Stunted"
                                                            {{ old('status_stunting', $examination->status_stunting) == 'Severely Stunted' ? 'selected' : '' }}>
                                                            Severely Stunted (Sangat Pendek)</option>
                                                    </select>
                                                </div>
                                                <div>
                                                    <x-input-label for="asupan_gizi" :value="__('Status Asupan Gizi')" />
                                                    <x-text-input id="asupan_gizi"
                                                        class="block mt-1 w-full bg-white text-sm" type="text"
                                                        name="asupan_gizi" :value="old('asupan_gizi', $examination->asupan_gizi)"
                                                        placeholder="Contoh: Cukup, Kurang" />
                                                </div>
                                                <div>
                                                    <x-input-label for="imunisasi_gizi" :value="__('Keterangan Imunisasi Gizi')" />
                                                    <x-text-input id="imunisasi_gizi"
                                                        class="block mt-1 w-full bg-white text-sm" type="text"
                                                        name="imunisasi_gizi" :value="old('imunisasi_gizi', $examination->imunisasi_gizi)"
                                                        placeholder="Contoh: Lengkap, Belum" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-pink-50 p-4 rounded-lg">
                                        <p class="text-xs font-bold text-pink-800 mb-3 uppercase">Khusus Ibu Hamil</p>
                                        <div class="space-y-4">
                                            <div>
                                                <x-input-label for="hpht" :value="__('HPHT (Hari Pertama Haid Terakhir)')" />
                                                <x-text-input id="hpht" class="block mt-1 w-full bg-white"
                                                    type="date" name="hpht"
                                                    :value="old('hpht', $examination->hpht)" />
                                                <p class="text-xs text-gray-400 mt-1">Tanggal pertama haid terakhir</p>
                                            </div>
                                            <div>
                                                <x-input-label for="tfu" :value="__('Tinggi Fundus Uteri (cm)')" />
                                                <x-text-input id="tfu" class="block mt-1 w-full bg-white"
                                                    type="number" step="0.01" name="tfu"
                                                    :value="old('tfu', $examination->tfu)" />
                                            </div>
                                            <div>
                                                <x-input-label for="djj" :value="__('Detak Jantung Janin (bpm)')" />
                                                <x-text-input id="djj" class="block mt-1 w-full bg-white"
                                                    type="number" name="djj" :value="old('djj', $examination->djj)" />
                                            </div>
                                            <div class="pt-2 border-t border-pink-200">
                                                <div>
                                                    <x-input-label for="tablet_fe" :value="__('Jumlah Tablet FE yang Diberikan')" />
                                                    <x-text-input id="tablet_fe" class="block mt-1 w-full bg-white"
                                                        type="number" name="tablet_fe" :value="old('tablet_fe', $examination->tablet_fe ?? 0)" />
                                                </div>
                                                <div class="flex items-center mt-3">
                                                    <input id="is_kek" type="checkbox" name="is_kek"
                                                        value="1"
                                                        {{ old('is_kek', $examination->is_kek) ? 'checked' : '' }}
                                                        class="rounded border-gray-300 text-pink-600 shadow-sm focus:ring-pink-500">
                                                    <label for="is_kek"
                                                        class="ms-2 text-sm text-gray-700">{{ __('Ibu Hamil KEK') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="md:col-span-2 mt-4">
                                <x-input-label for="catatan" :value="__('Catatan Tambahan')" />
                                <textarea id="catatan" name="catatan" rows="3"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('catatan', $examination->catatan) }}</textarea>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Perbarui Data') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
