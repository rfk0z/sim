<x-layout>
    <x-slot:title>Daftar Pengumuman</x-slot:title>

    <div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #4A6FA5; font-size: 2.5rem; margin-bottom: 10px;">Daftar Pengumuman</h1>
            <p style="color: #2C3E50; font-size: 1.1rem;">Informasi terbaru untuk mahasiswa</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
            @foreach ($pengumuman as $item)
            <div style="background-color: white; border-radius: 10px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 4px solid #4A6FA5;">

                <div style="display: inline-block; padding: 5px 10px; background-color: #E8C547; color: white; border-radius: 15px; font-size: 12px; font-weight: bold; margin-bottom: 15px;">
                    {{ $item['kategori'] ?? 'Umum' }}
                </div>

                <h3 style="color: #4A6FA5; font-size: 1.2rem; font-weight: bold; margin-bottom: 10px; line-height: 1.4;">
                    {{ $item['judul'] }}
                </h3>

                <p style="color: #2C3E50; line-height: 1.6; margin-bottom: 15px; font-size: 14px;">
                    {{ $item['isi'] }}
                </p>

                <div style="font-size: 12px; color: #6B7280;">
                    📅 {{ $item['tanggal'] ?? date('Y-m-d') }}
                </div>
            </div>
            @endforeach
        </div>

        @if (empty($pengumuman))
        <div style="text-align: center; background-color: #4A6FA5; color: white; padding: 40px; border-radius: 10px; margin-top: 20px;">
            <h2 style="font-size: 1.5rem; margin-bottom: 10px;">Belum ada pengumuman saat ini</h2>
            <p style="font-size: 1rem;">Silakan periksa kembali nanti untuk informasi terbaru</p>
        </div>
        @endif
    </div>
</x-layout>
