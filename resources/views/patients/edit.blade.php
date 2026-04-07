<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('patients.update', $patient) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="nama" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $patient->nama)" required autofocus />
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $patient->tanggal_lahir)" required />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="L" {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tautkan Akun Pengguna</h3>
                                <p class="text-sm text-gray-500 mb-4">Pilih akun yang sudah terdaftar <b>ATAU</b> buat akun baru untuk pasien ini secara langsung.</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-4 rounded-lg border border-gray-100">
                                    <div class="md:col-span-2">
                                        <x-input-label for="user_id" :value="__('1. Pilih Akun Terdaftar (Gunakan dropdown ini jika akun sudah ada)')" />
                                        <select id="user_id" name="user_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="">-- Ingin Buat Akun Baru / Tanpa Akun --</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id', $patient->user_id) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }} ({{ $user->email }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                                    </div>
                                    
                                    <div class="md:col-span-2 mt-2 border-t border-gray-200 pt-3">
                                        <h4 class="text-sm font-semibold text-gray-700">2. ATAU Buat Akun Baru:</h4>
                                        <p class="text-xs text-gray-500">Abaikan bagian ini jika Anda sudah memilih akun di atas.</p>
                                    </div>

                                    <div>
                                        <x-input-label for="new_user_name" :value="__('Nama Pemilik Akun')" />
                                        <x-text-input id="new_user_name" class="block mt-1 w-full bg-white" type="text" name="new_user_name" :value="old('new_user_name')" />
                                        <x-input-error :messages="$errors->get('new_user_name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="new_user_email" :value="__('Email')" />
                                        <x-text-input id="new_user_email" class="block mt-1 w-full bg-white" type="email" name="new_user_email" :value="old('new_user_email')" />
                                        <x-input-error :messages="$errors->get('new_user_email')" class="mt-2" />
                                    </div>

                                    <div class="md:col-span-2">
                                        <x-input-label for="new_user_password" :value="__('Kata Sandi (Min: 8 Karakter)')" />
                                        <x-text-input id="new_user_password" class="block mt-1 w-full md:w-1/2 bg-white" type="password" name="new_user_password" />
                                        <x-input-error :messages="$errors->get('new_user_password')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <x-input-label for="kategori" :value="__('Kategori')" />
                                <select id="kategori" name="kategori" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="balita" {{ old('kategori', $patient->kategori) == 'balita' ? 'selected' : '' }}>Balita</option>
                                    <option value="ibu_hamil" {{ old('kategori', $patient->kategori) == 'ibu_hamil' ? 'selected' : '' }}>Ibu Hamil</option>
                                    <option value="ibu_nifas" {{ old('kategori', $patient->kategori) == 'ibu_nifas' ? 'selected' : '' }}>Ibu Nifas</option>
                                </select>
                                <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                            </div>

                            <div class="flex items-center mt-4">
                                <input id="has_kms" type="checkbox" name="has_kms" value="1" {{ old('has_kms', $patient->has_kms) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <label for="has_kms" class="ms-2 text-sm text-gray-600">{{ __('Memiliki KMS (Kartu Menuju Sehat)') }}</label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Perbarui') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
