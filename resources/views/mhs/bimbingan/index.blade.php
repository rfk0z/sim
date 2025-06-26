<x-mhs-layout>
    <x-slot:title>Daftar Bimbingan</x-slot>

    {{-- Header Section --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Daftar Bimbingan</h1>
            <p class="text-gray-600">Kelola jadwal bimbingan dengan dosen pembimbing</p>
        </div>
        <a href="{{ route('mhs.bimbingan.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14m-7-7h14"/>
            </svg>
            <span>Tambah Bimbingan</span>
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11H7l4-4 4 4h-2v4H9v-4z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Content Section --}}
    @if($bimbingan->count() > 0)
        {{-- Bimbingan List --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Bimbingan</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $bimbingan->total() }} bimbingan ditemukan</p>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($bimbingan as $item)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $item->topik }}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($item->status_validasi == 'Approved')
                                            bg-green-100 text-green-800
                                        @elseif($item->status_validasi == 'Rejected')
                                            bg-red-100 text-red-800
                                        @else
                                            bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ $item->status_validasi }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                            <circle cx="12" cy="7" r="4"/>
                                        </svg>
                                        {{ $item->dosen->nama ?? 'Dosen tidak ditemukan' }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12,6 12,12 16,14"/>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}
                                    </div>
                                </div>

                                <p class="text-gray-700 mb-3 line-clamp-2">{{ $item->deskripsi }}</p>

                                @if($item->dokumen->count() > 0)
                                    <div class="flex items-center text-sm text-gray-600 mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>
                                            <polyline points="14,2 14,8 20,8"/>
                                        </svg>
                                        {{ $item->dokumen->count() }} dokumen
                                    </div>
                                @endif

                                @if($item->komentar->count() > 0)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10z"/>
                                        </svg>
                                        {{ $item->komentar->count() }} komentar
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                <a href="{{ route('mhs.bimbingan.show', $item->id_bimbingan) }}"
                                   class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-lg text-sm flex items-center space-x-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                    <span>Detail</span>
                                </a>

                                @if($item->status_validasi == 'Pending')
                                    <a href="{{ route('mhs.bimbingan.edit', $item->id_bimbingan) }}"
                                       class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-2 rounded-lg text-sm flex items-center space-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>

                                    <form action="{{ route('mhs.bimbingan.destroy', $item->id_bimbingan) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-sm flex items-center space-x-1"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus bimbingan ini?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="3,6 5,6 21,6"/>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($bimbingan->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $bimbingan->links() }}
                </div>
            @endif
        </div>
    @else
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="text-center py-16 px-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="mx-auto text-gray-400 mb-4">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Bimbingan</h3>
                <p class="text-gray-600 mb-6">Buat jadwal bimbingan dengan dosen untuk memulai proses pembimbingan.</p>
                <a href="{{ route('mhs.bimbingan.create') }}"
                   class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14m-7-7h14"/>
                    </svg>
                    <span>Buat Jadwal Bimbingan</span>
                </a>
            </div>
        </div>
    @endif
</x-mhs-layout>
