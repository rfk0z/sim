<x-layout>
    <div class="font-sans">
        <!-- Warning Message -->
        @if (session('warn'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="max-w-md mx-auto mt-6 px-4 py-3 rounded-xl shadow-lg bg-red-50 border border-red-200 flex items-start justify-between gap-3">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 17h0a9 9 0 100-18 9 9 0 000 18z" />
                    </svg>
                    <div class="text-sm text-red-800">
                        {{ session('warn') }}
                    </div>
                </div>
                <button @click="show = false"
                    class="text-red-600 hover:text-red-800 text-lg font-bold leading-none focus:outline-none">
                    &times;
                </button>
            </div>
        @endif

        <!-- Hero Section -->
        <section id="beranda" x-data="{
            currentSlide: 0,
            slides: [
                { image: 'img/xa.jpg' },
                { image: 'https://www.uni-wuerzburg.de/fileadmin/_processed_/c/d/csm_0320krishna-www_2da0374409.jpg' },
                { image: 'img/tw.jpg' }
            ],
            interval: null,
            init() {
                this.startAutoSlide();
            },
            startAutoSlide() {
                this.interval = setInterval(() => this.next(), 8000);
            },
            resetAutoSlide() {
                clearInterval(this.interval);
                this.startAutoSlide();
            },
            next() {
                this.currentSlide = (this.currentSlide + 1) % this.slides.length;
                this.resetAutoSlide();
            },
            prev() {
                this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
                this.resetAutoSlide();
            },
            goToSlide(index) {
                this.currentSlide = index;
                this.resetAutoSlide();
            }
        }" x-init="init()"
            class="relative w-full h-64 sm:h-96 md:h-screen overflow-hidden">

            <!-- Slides Container -->
            <div class="absolute inset-0 flex transition-transform duration-1000 ease-in-out"
                :style="`transform: translateX(-${currentSlide * 100}%);`">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="min-w-full h-full bg-cover bg-center"
                        :style="`background-image: url(${slide.image})`"></div>
                </template>
            </div>

            <!-- Overlay -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#27548A]/80 via-[#27548A]/70 to-slate-900/60 z-0"></div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-[#F3F3E0] px-4">
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-4 drop-shadow-2xl tracking-wide">SELAMAT DATANG!</h1>
                <p class="text-lg sm:text-xl md:text-2xl mb-8 drop-shadow-lg opacity-95">SISTEM BIMBINGAN TUGAS AKHIR</p>
                <div class="flex flex-wrap gap-4 sm:gap-6 justify-center">
                    <a href="#jelajahi"
                        class="bg-[#27548A] hover:bg-[#1e4470] text-[#F3F3E0] font-semibold py-3 px-8 sm:py-4 sm:px-10 rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 backdrop-blur-sm">
                        Jelajahi Sistem
                    </a>
                    <a href="#layanan"
                        class="border-2 border-[#F3F3E0] hover:bg-[#F3F3E0] hover:text-[#27548A] font-semibold py-3 px-8 sm:py-4 sm:px-10 rounded-full transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 backdrop-blur-sm">
                        Layanan Bimbingan
                    </a>
                </div>
            </div>

            <!-- Arrows -->
            <button @click="prev()"
                class="absolute z-20 top-1/2 left-4 sm:left-6 -translate-y-1/2 bg-[#27548A]/60 hover:bg-[#27548A]/80 text-[#F3F3E0] p-3 sm:p-4 rounded-full transition-all duration-300 backdrop-blur-sm shadow-lg hover:shadow-xl transform hover:scale-110"
                aria-label="Previous Slide">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button @click="next()"
                class="absolute z-20 top-1/2 right-4 sm:right-6 -translate-y-1/2 bg-[#27548A]/60 hover:bg-[#27548A]/80 text-[#F3F3E0] p-3 sm:p-4 rounded-full transition-all duration-300 backdrop-blur-sm shadow-lg hover:shadow-xl transform hover:scale-110"
                aria-label="Next Slide">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 sm:w-7 sm:h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Dots -->
            <div class="absolute bottom-6 sm:bottom-8 left-1/2 transform -translate-x-1/2 flex gap-3 z-20">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="goToSlide(index)"
                        :class="{
                            'bg-[#F3F3E0] scale-125 shadow-lg': currentSlide === index,
                            'bg-[#F3F3E0]/50 hover:bg-[#F3F3E0]/70': currentSlide !== index
                        }"
                        class="w-3 h-3 sm:w-4 sm:h-4 rounded-full transition-all duration-300 transform backdrop-blur-sm"></button>
                </template>
            </div>
        </section>

        <!-- Explore System Section -->
        <section id="jelajahi" class="bg-[#F3F3E0] py-16 sm:py-20 md:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#27548A] mb-4 sm:mb-6">JELAJAHI SISTEM BIMBINGAN</h2>
                <p class="text-base sm:text-lg md:text-xl text-slate-700 mb-12 sm:mb-16 max-w-3xl mx-auto leading-relaxed">
                    Melalui sistem ini Anda dapat mengakses berbagai fitur bimbingan tugas akhir, mulai dari pendaftaran,
                    konsultasi, monitoring progress, hingga evaluasi hasil.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 md:gap-10">
                    @php
                        $items = [
                            [
                                'title' => 'Profil Mahasiswa',
                                'url' => '/profil-mahasiswa',
                                'icon' => '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
                                'gradient' => 'from-[#27548A] to-[#1e4470]'
                            ],
                            [
                                'title' => 'Progress Bimbingan',
                                'url' => '/progress-bimbingan',
                                'icon' => '<path d="M12 16v5"/><path d="M16 14v7"/><path d="M20 10v11"/><path d="m22 3-8.646 8.646a.5.5 0 0 1-.708 0L9.354 8.354a.5.5 0 0 0-.707 0L2 15"/><path d="M4 18v3"/><path d="M8 14v7"/>',
                                'gradient' => 'from-slate-600 to-slate-700'
                            ],
                            [
                                'title' => 'Jadwal Konsultasi',
                                'url' => '/jadwal-konsultasi',
                                'icon' => '<rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/>',
                                'gradient' => 'from-[#27548A] to-[#1e4470]'
                            ],
                            [
                                'title' => 'Dokumen Tugas Akhir',
                                'url' => '/dokumen-ta',
                                'icon' => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/>',
                                'gradient' => 'from-slate-600 to-slate-700'
                            ],
                        ];
                    @endphp

                    @foreach ($items as $item)
                        <a href="{{ $item['url'] }}"
                            class="group block rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-6 sm:p-8 text-center bg-gradient-to-br {{ $item['gradient'] }} hover:scale-105 transform backdrop-blur-sm border border-white/20">
                            <div class="flex items-center justify-center mb-4 sm:mb-6">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-[#F3F3E0]/90 flex items-center justify-center shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10 text-[#27548A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        {!! $item['icon'] !!}
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-[#F3F3E0] group-hover:text-white transition-colors leading-tight">
                                {{ $item['title'] }}
                            </h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="layanan" class="bg-gradient-to-br from-slate-50 to-slate-100 py-16 sm:py-20 md:py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 sm:mb-16">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-[#27548A] mb-4 sm:mb-6">LAYANAN BIMBINGAN TUGAS AKHIR</h2>
                    <p class="text-base sm:text-lg md:text-xl text-slate-700 max-w-3xl mx-auto leading-relaxed">
                        Nikmati kemudahan layanan bimbingan tugas akhir yang terintegrasi, efisien, dan terpantau dengan baik.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-10 md:gap-12 max-w-5xl mx-auto">
                    <!-- Online Guidance Card -->
                    <div class="bg-gradient-to-br from-[#27548A] to-[#1e4470] rounded-3xl shadow-2xl p-8 sm:p-10 flex flex-col hover:shadow-3xl transition-all duration-500 border border-white/10 hover:scale-105 transform backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-[#F3F3E0] p-5 sm:p-6 rounded-2xl shadow-xl mb-6 sm:mb-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 sm:h-12 sm:w-12 text-[#27548A]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-[#F3F3E0] mb-4 sm:mb-6">KONSULTASI ONLINE</h3>
                            <p class="text-base sm:text-lg text-[#F3F3E0]/90 mb-6 sm:mb-8 leading-relaxed">
                                Lakukan konsultasi dengan dosen pembimbing secara online, jadwal fleksibel dengan sistem monitoring yang terstruktur.
                            </p>
                            <a href="/konsultasi-online"
                                class="inline-block bg-[#F3F3E0] text-[#27548A] font-bold py-3 px-8 sm:py-4 sm:px-10 text-base sm:text-lg rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 transform">
                                Mulai Konsultasi
                            </a>
                        </div>
                    </div>

                    <!-- Document Management Card -->
                    <div class="bg-gradient-to-br from-slate-600 to-slate-700 rounded-3xl shadow-2xl p-8 sm:p-10 flex flex-col hover:shadow-3xl transition-all duration-500 border border-white/10 hover:scale-105 transform backdrop-blur-sm">
                        <div class="flex flex-col items-center text-center">
                            <div class="bg-[#F3F3E0] p-5 sm:p-6 rounded-2xl shadow-xl mb-6 sm:mb-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 sm:h-12 sm:w-12 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold text-[#F3F3E0] mb-4 sm:mb-6">MANAJEMEN DOKUMEN</h3>
                            <p class="text-base sm:text-lg text-[#F3F3E0]/90 mb-6 sm:mb-8 leading-relaxed">
                                Kelola semua dokumen tugas akhir Anda dengan mudah, upload revisi, dan dapatkan feedback dari pembimbing.
                            </p>
                            <a href="/manajemen-dokumen"
                                class="inline-block bg-[#F3F3E0] text-slate-700 font-bold py-3 px-8 sm:py-4 sm:px-10 text-base sm:text-lg rounded-full shadow-xl hover:shadow-2xl transition-all duration-300 hover:scale-105 transform">
                                Kelola Dokumen
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- News Section -->
        <section id="berita" class="py-16 sm:py-20 bg-[#F3F3E0]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 sm:mb-16">
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#27548A] mb-3 sm:mb-4">INFORMASI TERBARU</h2>
                    <p class="text-base sm:text-lg text-slate-700">Pengumuman dan informasi terkini seputar bimbingan tugas akhir</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach ($berita as $item)
                        <div class="bg-gradient-to-br from-white to-slate-50 rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-500 flex flex-col h-full border border-white/50 hover:scale-105 transform backdrop-blur-sm">
                            <img class="h-48 w-full object-cover" src="{{ asset('storage/' . $item->gambar_cover) }}" alt="Foto Berita">
                            <div class="p-6 flex flex-col justify-between flex-grow">
                                <div>
                                    <p class="text-sm text-[#27548A] mb-3 font-medium">Diterbitkan pada {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d F Y') }}</p>
                                    <h3 class="text-lg sm:text-xl font-bold text-slate-800 mb-3 line-clamp-2 leading-tight">{{ $item->judul_berita }}</h3>
                                    <p class="text-sm sm:text-base text-slate-600 mb-4 line-clamp-3 leading-relaxed">
                                        {{ Str::limit(strip_tags($item->isi_berita), 120) }}
                                    </p>
                                </div>
                                <div class="mt-auto">
                                    <a href="{{ route('index.berita', $item->id_berita) }}"
                                        class="text-[#27548A] hover:text-[#1e4470] text-sm sm:text-base font-bold hover:underline flex items-center transition-colors duration-300">
                                        Baca Selengkapnya
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 ml-2 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12 sm:mt-16 text-center">
                    <a href="{{ route('index.berita') }}"
                        class="inline-flex items-center gap-3 px-10 py-4 sm:px-12 sm:py-5 bg-gradient-to-r from-[#27548A] to-[#1e4470] text-[#F3F3E0] text-base sm:text-lg font-bold rounded-full hover:shadow-2xl transition-all duration-500 transform hover:scale-105 backdrop-blur-sm border border-white/20">
                        Lihat Informasi Lainnya
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </div>
</x-layout>
