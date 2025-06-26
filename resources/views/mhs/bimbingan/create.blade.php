<x-mhs-layout>
    <x-slot:title>Tambah Bimbingan</x-slot>

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Bimbingan</h1>
            <p class="text-gray-600 mt-2">Buat jadwal bimbingan baru dengan dosen pembimbing</p>
        </div>
        <a href="{{ route('mhs.bimbingan.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl flex items-center space-x-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 12H6m0 0l4 4m-4-4l4-4"/>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    {{-- Alert Messages --}}
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-6 py-4 rounded-xl mb-8" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Terdapat kesalahan!</p>
                    <ul class="mt-2 list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- Form Section --}}
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="px-8 py-6 border-b border-gray-200 bg-gray-50">
            <h3 class="text-xl font-semibold text-gray-900">Form Tambah Bimbingan</h3>
            <p class="text-sm text-gray-600 mt-2">Lengkapi data bimbingan dengan dosen pembimbing</p>
        </div>

        <form action="{{ route('mhs.bimbingan.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf

            {{-- Dosen Pembimbing Section --}}
            <div class="mb-8">
                <label for="nidn" class="block text-sm font-semibold text-gray-700 mb-3">
                    Dosen Pembimbing <span class="text-red-500">*</span>
                </label>
                <select name="nidn" id="nidn"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nidn') border-red-500 @enderror transition-colors">
                    <option value="">Pilih Dosen Pembimbing</option>
                    @if(isset($dosen))
                        @foreach($dosen as $item)
                            <option value="{{ $item->id_nidn }}" {{ old('nidn') == $item->id_nidn ? 'selected' : '' }}>
                                {{ $item->nidn }} - {{ $item->nama }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('nidn')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Topik Bimbingan Section --}}
            <div class="mb-8">
                <label for="topik" class="block text-sm font-semibold text-gray-700 mb-3">
                    Topik Bimbingan <span class="text-red-500">*</span>
                </label>
                <input type="text"
                       name="topik"
                       id="topik"
                       value="{{ old('topik') }}"
                       placeholder="Masukkan topik bimbingan"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('topik') border-red-500 @enderror transition-colors">
                @error('topik')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal dan Waktu Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                {{-- Tanggal --}}
                <div>
                    <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-3">
                        Tanggal Bimbingan <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           name="tanggal"
                           id="tanggal"
                           value="{{ old('tanggal') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal') border-red-500 @enderror transition-colors">
                    @error('tanggal')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Waktu --}}
                <div>
                    <label for="waktu" class="block text-sm font-semibold text-gray-700 mb-3">
                        Waktu Bimbingan <span class="text-red-500">*</span>
                    </label>
                    <input type="time"
                           name="waktu"
                           id="waktu"
                           value="{{ old('waktu') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('waktu') border-red-500 @enderror transition-colors">
                    @error('waktu')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi Section --}}
            <div class="mb-8">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-3">
                    Deskripsi Bimbingan <span class="text-red-500">*</span>
                </label>
                <textarea name="deskripsi"
                          id="deskripsi"
                          rows="5"
                          placeholder="Jelaskan detail bimbingan yang akan dilakukan..."
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('deskripsi') border-red-500 @enderror transition-colors resize-vertical">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Upload Dokumen Section --}}
            <div class="mb-10">
                <label for="dokumen" class="block text-sm font-semibold text-gray-700 mb-3">
                    Dokumen Pendukung
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-gray-400 transition-colors bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-400 mb-4">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                        <polyline points="14,2 14,8 20,8"/>
                    </svg>
                    <input type="file"
                           name="dokumen[]"
                           id="dokumen"
                           multiple
                           accept=".pdf,.doc,.docx"
                           class="hidden"
                           onchange="updateFileList(this)">
                    <label for="dokumen" class="cursor-pointer">
                        <span class="text-blue-600 hover:text-blue-700 font-semibold text-lg">Klik untuk upload</span>
                        <span class="text-gray-600 text-lg"> atau drag & drop file</span>
                    </label>
                    <p class="text-sm text-gray-500 mt-3">Mendukung: PDF, DOC, DOCX (Max: 2MB per file)</p>
                    <div id="file-list" class="mt-4 text-left"></div>
                </div>
                @error('dokumen.*')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex justify-end space-x-4 pt-8 border-t border-gray-200">
                <a href="{{ route('mhs.bimbingan.index') }}"
                   class="px-8 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit"
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center space-x-2 transition-colors font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17,21 17,13 7,13 7,21"/>
                        <polyline points="7,3 7,8 15,8"/>
                    </svg>
                    <span>Simpan Bimbingan</span>
                </button>
            </div>
        </form>
    </div>

    <script>
        function updateFileList(input) {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';

            if (input.files.length > 0) {
                const listContainer = document.createElement('div');
                listContainer.className = 'space-y-3';

                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'flex items-center justify-between bg-white p-3 rounded-lg border border-gray-200';

                    const fileInfo = document.createElement('div');
                    fileInfo.className = 'flex items-center space-x-3';
                    fileInfo.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                            <polyline points="14,2 14,8 20,8"/>
                        </svg>
                        <div>
                            <span class="text-sm font-medium text-gray-900">${file.name}</span>
                            <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                        </div>
                    `;

                    fileItem.appendChild(fileInfo);
                    listContainer.appendChild(fileItem);
                }

                fileList.appendChild(listContainer);
            }
        }

        // Set minimum date to today
        document.getElementById('tanggal').min = new Date().toISOString().split('T')[0];
    </script>
</x-mhs-layout>
