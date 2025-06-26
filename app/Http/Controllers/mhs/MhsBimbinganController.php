<?php
namespace App\Http\Controllers\mhs;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use App\Models\Dokumen;
use App\Models\Dosen; // Tambahkan import model Dosen
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MhsBimbinganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:3'); // Hanya mahasiswa
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            return view('mhs.bimbingan.index', ['bimbingan' => collect()]);
        }

        $nim = $user->mahasiswa->id_nim; // Changed from nim to id_nim

        $bimbingan = Bimbingan::with(['dosen', 'dokumen', 'komentar'])
            ->where('nim', $nim)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('mhs.bimbingan.index', compact('bimbingan'));
    }

    public function show($id)
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            abort(403, 'Unauthorized action.');
        }

        $nim = $user->mahasiswa->id_nim; // Changed from nim to id_nim

        $bimbingan = Bimbingan::with([
            'dosen',
            'dokumen',
            'komentar' => function ($query) {
                $query->with(['pengirim:id_user,username'])
                    ->orderBy('waktu_kirim', 'asc');
            }
        ])
        ->where('nim', $nim)
        ->findOrFail($id);

        return view('mhs.bimbingan.show', compact('bimbingan'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            abort(403, 'Unauthorized action.');
        }

        // Ambil semua data dosen yang tersedia
        $dosen = Dosen::orderBy('nama', 'asc')->get();

        return view('mhs.bimbingan.create', compact('dosen'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nidn' => 'required|exists:dosens,id_nidn',
            'topik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $nim = $user->mahasiswa->id_nim; // Changed from nim to id_nim

        // Insert langsung ke database tanpa timestamps
        $bimbinganId = DB::table('bimbingan')->insertGetId([
            'nim' => $nim,
            'nidn' => $request->nidn,
            'topik' => $request->topik,
            'catatan' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'status_validasi' => 'Pending',
        ]);

        // Buat object untuk kompatibilitas
        $bimbingan = (object)['id_bimbingan' => $bimbinganId];

        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('dokumen_bimbingan', 'public');

                Dokumen::create([
                    'id_bimbingan' => $bimbingan->id_bimbingan,
                    'nama_file' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('mhs.bimbingan.index')
            ->with('success', 'Bimbingan berhasil dibuat dan menunggu validasi dosen.');
    }

    public function edit($id)
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            abort(403, 'Unauthorized action.');
        }

        $nim = $user->mahasiswa->id_nim; // Changed from nim to id_nim

        $bimbingan = Bimbingan::with(['dokumen', 'komentar.pengirim'])
            ->where('nim', $nim)
            ->where('status_validasi', 'Pending') // Hanya bisa edit yang masih pending
            ->findOrFail($id);

        // Ambil data dosen untuk dropdown di form edit
        $dosen = Dosen::orderBy('nama', 'asc')->get();

        return view('mhs.bimbingan.edit', compact('bimbingan', 'dosen'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            abort(403, 'Unauthorized action.');
        }

        $nim = $user->mahasiswa->id_nim; // Changed from nim to id_nim

        $request->validate([
            'topik' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'dokumen.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $bimbingan = Bimbingan::where('nim', $nim)
            ->where('status_validasi', 'Pending') // Hanya bisa update yang masih pending
            ->findOrFail($id);

        // Update langsung ke database tanpa timestamps
        DB::table('bimbingan')
            ->where('id_bimbingan', $id)
            ->where('nim', $nim)
            ->where('status_validasi', 'Pending')
            ->update([
                'topik' => $request->topik,
                'catatan' => $request->deskripsi,
                'tanggal' => $request->tanggal,
            ]);

        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $file) {
                $path = $file->store('dokumen_bimbingan', 'public');

                Dokumen::create([
                    'id_bimbingan' => $bimbingan->id_bimbingan,
                    'nama_file' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'uploaded_at' => now(),
                ]);
            }
        }

        return redirect()->route('mhs.bimbingan.index')
            ->with('success', 'Bimbingan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            abort(403, 'Unauthorized action.');
        }

        $nim = $user->mahasiswa->id_nim; // Changed from nim to id_nim

        $bimbingan = Bimbingan::where('nim', $nim)
            ->where('status_validasi', 'Pending') // Hanya bisa hapus yang masih pending
            ->findOrFail($id);

        // Hapus dokumen terkait
        foreach ($bimbingan->dokumen as $dokumen) {
            if (file_exists(storage_path('app/public/' . $dokumen->file_path))) {
                unlink(storage_path('app/public/' . $dokumen->file_path));
            }
            $dokumen->delete();
        }

        $bimbingan->delete();

        return redirect()->route('mhs.bimbingan.index')
            ->with('success', 'Bimbingan berhasil dihapus.');
    }
}
