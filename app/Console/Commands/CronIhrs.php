<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CronIhrs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:ihrs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // log cron success run
        Log::info("Cron IHRS Berhasil di jalankan " . Carbon::now()->format('Y-m-d H:i:s'));

        // Update Status Resigned
        $updateResigned = DB::connection('sqlsrv_hrd')->table('hrd.tbl_makar')
            ->where('tgl_resign', '<=', Carbon::now())
            ->where('status_karyawan', 'Resigned')
            ->update(['status_aktif' => 0]);

        if ($updateResigned) {
            Log::info("Update Status Resigned berhasil dilakukan.");
        } else {
            Log::info("Tidak ada data yang perlu diperbarui untuk Status Resigned.");
        }

        // Generate Cuti Tahunan
        $sheet = DB::connection('sqlsrv_hrd')->table('hrd.tbl_makar')
            ->selectRaw("
                *,
                FORMAT(tgl_tetap, 'dd MMMM', 'id-ID') AS awal,
                YEAR(GETDATE()) AS thn_awal,
                FORMAT(DATEADD(DAY, -1, DATEADD(MONTH, 12, tgl_tetap)), 'dd MMMM', 'id-ID') AS akhir,
                YEAR(DATEADD(YEAR, 1, GETDATE())) AS thn_akhir,
                YEAR(DATEADD(YEAR, -1, GETDATE())) AS thn_awal_periode_gen,
                YEAR(GETDATE()) AS thn_akhir_periode_gen
            ")
            ->where('status_karyawan', 'Tetap')
            ->whereNull('gaji')
            ->where('status_aktif', 1)
            ->whereRaw("FORMAT(tgl_tetap, 'dd MMMM', 'id-ID') = FORMAT(GETDATE(), 'dd MMMM', 'id-ID')")
            ->whereNotIn(DB::raw("YEAR(tgl_tetap)"), [date('Y'), date('Y') + 1])
            ->where('tgl_generate_cuti', '!=', Carbon::today()->toDateString())
            ->orderByRaw("DATEADD(DAY, -1, DATEADD(MONTH, 12, tgl_tetap)) DESC")
            ->get();


        if ($sheet->isEmpty()) {
            Log::info("Tidak ada data yang perlu diperbarui untuk Generate Cuti Tahunan.");
        } else {
            foreach ($sheet as $value) {
                $saldosisacuti = ($value->sisa_cuti <= 0) ? 12 + $value->sisa_cuti : 12;

                $data = [
                    'no_scan' => $value->no_scan,
                    'sisa_cuti' => $saldosisacuti,
                    'sisa_cuti_th_sebelumnya' => $value->sisa_cuti,
                    'tgl_generate_cuti' => Carbon::now()->toDateString()
                ];

                DB::connection('sqlsrv_hrd')->table('hrd.tbl_makar')
                    ->where('no_scan', $value->no_scan)
                    ->update($data);

                $alasan = ($value->sisa_cuti) ? "Sisa cuti $value->sisa_cuti telah dibayarkan (Periode $value->thn_awal_periode_gen - $value->thn_akhir_periode_gen)." : "Tidak ada sisa cuti yang dibayarkan. Sisa cuti habis.";

                $data_histori = [
                    'kode_cuti' => "GEN-" . date('Ym'),
                    'nip' => $value->no_scan,
                    'dept' => $value->dept,
                    'saldo_cuti' => $saldosisacuti,
                    'days_or_month' => "Hari",
                    'ket' => "th." . date('Y'),
                    'alasan' => $alasan
                ];

                DB::connection('sqlsrv_hrd')->table('hrd.permohonan_izin_cuti')->insert($data_histori);
            }
            Log::info("Generate Cuti Tahunan berhasil dilakukan untuk " . count($sheet) . " karyawan.");
        }

        // Update Data Career Transition (Mutasi, Promosi, Demosi)
        $sheet_tran = DB::connection('sqlsrv_hrd')->table('hrd.career_transition')
            ->select('no_scan', 'proses', 'tgl_efektif', 'dept_baru', 'bagian_baru', 'golongan_baru', 'jabatan_baru', 'kode_jabatan_baru', 'atasan1', 'atasan2')
            ->whereDate('tgl_efektif', Carbon::today())
            ->get();

        if ($sheet_tran->isEmpty()) {
            Log::info("Tidak ada data yang perlu diperbarui untuk Career Transition.");
        } else {
            foreach ($sheet_tran as $value) {
                if ($value->proses == 'mutasi') {
                    $data = [
                        'dept' => $value->dept_baru,
                        'bagian' => $value->bagian_baru,
                    ];
                } elseif ($value->atasan1 !== null && $value->atasan2 !== null) {
                    $data = [
                        'dept' => $value->dept_baru,
                        'bagian' => $value->bagian_baru,
                        'golongan' => $value->golongan_baru,
                        'jabatan' => $value->jabatan_baru,
                        'kode_jabatan' => $value->kode_jabatan_baru,
                        'atasan1' => $value->atasan1,
                        'atasan2' => $value->atasan2,
                    ];
                } else {
                    $data = [
                        'dept' => $value->dept_baru,
                        'bagian' => $value->bagian_baru,
                        'golongan' => $value->golongan_baru,
                        'jabatan' => $value->jabatan_baru,
                        'kode_jabatan' => $value->kode_jabatan_baru,
                    ];
                }

                DB::connection('sqlsrv_hrd')->table('hrd.tbl_makar')
                    ->where('no_scan', $value->no_scan)
                    ->update($data);
            }
            Log::info("Update Career Transition berhasil dilakukan untuk " . count($sheet_tran) . " karyawan.");
        }

        // Update Masa Kerja Karyawan baru
        $updateMasaKerja = DB::connection('sqlsrv_hrd')->table('hrd.tbl_makar')
            ->where('tgl_seragam', '<=', Carbon::now())
            ->where('status_seragam', 'BELUM')
            ->where('status_idcard', 'BELUM')
            ->where('status_karyawan', '!=', 'Resigned')
            ->update(['masa_kerja' => 6]);

        if ($updateMasaKerja) {
            Log::info("Update Masa Kerja berhasil dilakukan.");
        } else {
            Log::info("Tidak ada data yang perlu diperbarui untuk Update Masa Kerja.");
        }

        // Update seragam
        $updateTglSeragam = DB::connection('sqlsrv_hrd')->table('hrd.tbl_makar')
            ->where('status_seragam', 'BELUM')
            ->where('status_idcard', 'BELUM')
            ->where('status_karyawan', '<>', 'Resigned') // Menggunakan <> sebagai pengganti !=
            ->update([
                'tgl_seragam' => DB::raw("DATEADD(MONTH, 6, tgl_masuk)")
            ]);


        if ($updateTglSeragam) {
            Log::info("Update Tanggal Seragam berhasil dilakukan.");
        } else {
            Log::info("Tidak ada data yang perlu diperbarui untuk Update Tanggal Seragam.");
        }

        return Command::SUCCESS;
    }
}
