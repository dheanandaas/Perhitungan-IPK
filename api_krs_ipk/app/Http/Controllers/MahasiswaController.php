<?php
namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\KRS;
use App\Models\IPK;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Method untuk mengambil data KRS dan menghitung IPS serta IPK.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getKRS(Request $request)
    {
        $nim = $request->query('nim');
        $semester = $request->query('semester');

        // Validasi input
        if (!$nim || !$semester) {
            return response()->json([
                'success' => false,
                'message' => 'NIM dan Semester harus diisi'
            ], 400);
        }

        // Ambil data mahasiswa
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'success' => false,
                'message' => 'Mahasiswa tidak ditemukan'
            ], 404);
        }

        // Ambil data KRS mahasiswa berdasarkan semester
        $krs = KRS::where('nim', $nim)->where('semester', $semester)->with('mataKuliah')->get();
        if ($krs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data KRS tidak ditemukan'
            ], 404);
        }

        // Menghitung IPS dan IPK
        $ips = $this->calculateIPS($krs);
        $ipk = $this->calculateIPK($nim);

        return response()->json([
            'success' => true,
            'data' => [
                'mahasiswa' => $mahasiswa,
                'krs' => $krs,
                'ips' => $ips,
                'ipk' => $ipk
            ]
        ]);
    }

    /**
     * Method untuk menghitung IPS berdasarkan KRS.
     *
     * @param \Illuminate\Support\Collection $krs
     * @return float
     */
    private function calculateIPS($krs)
    {
        $totalNilai = 0;
        $totalSKS = 0;

        foreach ($krs as $item) {
            $sks = $item->mataKuliah->sks;
            $nilai = $this->convertNilaiToSkala4($item->nilai);

            $totalNilai += $sks * $nilai;
            $totalSKS += $sks;
        }

        return $totalSKS > 0 ? round($totalNilai / $totalSKS, 2) : 0;
    }

    /**
     * Method untuk menghitung IPK berdasarkan data IPK yang tersimpan.
     *
     * @param string $nim
     * @return float
     */
    private function calculateIPK($nim)
    {
        $ipkRecords = IPK::where('nim', $nim)->get();

        $totalNilai = 0;
        $totalSKS = 0;

        foreach ($ipkRecords as $record) {
            $totalNilai += $record->ips * $record->semester;  // Asumsi jumlah SKS per semester
            $totalSKS += $record->semester;
        }

        return $totalSKS > 0 ? round($totalNilai / $totalSKS, 2) : 0;
    }

    /**
     * Method untuk mengonversi nilai huruf ke skala 4.
     *
     * @param string $nilai
     * @return int
     */
    private function convertNilaiToSkala4($nilai)
    {
        switch (strtoupper($nilai)) {
            case 'A':
                return 4;
            case 'B':
                return 3;
            case 'C':
                return 2;
            case 'D':
                return 1;
            default:
                return 0;
        }
    }
}
