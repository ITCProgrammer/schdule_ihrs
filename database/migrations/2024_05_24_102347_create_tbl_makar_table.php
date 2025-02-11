<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_makar', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('no_ktp', 16)->nullable()->index('no_ktp');
            $table->string('nik_krishand', 50)->nullable();
            $table->string('no_scan', 6)->default('')->index('no_scan');
            $table->string('npwp')->nullable()->index('npwp');
            $table->string('nama', 128)->nullable()->index('nama');
            $table->string('tempat_lahir', 50)->nullable()->index('tempat_lahir');
            $table->string('tgl_lahir', 50)->index('tgl_lahir');
            $table->string('alamat_ktp', 500)->nullable()->index('alamat_ktp');
            $table->string('alamat_domisili')->nullable()->index('alamat_domisili');
            $table->string('alamat_npwp')->nullable()->index('alamat_npwp');
            $table->string('kecamatan_domisili', 128)->nullable()->index('kecamatan_domisili');
            $table->string('kabupaten_domisili', 128)->nullable()->index('kabupaten_domisili');
            $table->string('kode_pos')->nullable();
            $table->string('status_rumah')->nullable();
            $table->string('agama', 50)->nullable()->index('agama');
            $table->string('jenis_kelamin', 10)->nullable()->index('jenis_kelamin')->comment('L = Laki-Laki, P = Perempuan');
            $table->string('status_kel', 5)->nullable()->index('status_kel');
            $table->string('nama_sekolah')->nullable();
            $table->string('pendidikan', 10)->nullable()->index('pendidikan');
            $table->string('jurusan', 50)->nullable()->index('jurusan');
            $table->string('ipk', 11)->nullable()->index('ipk');
            $table->string('gol_darah', 10)->nullable()->index('gol_darah');
            $table->string('email_pribadi', 128)->nullable()->index('email_pribadi');
            $table->string('no_hp', 13)->nullable()->index('no_hp');
            $table->string('pengalaman_kerja', 500)->nullable()->index('pengalaman_kerja');
            $table->string('keterampilan_khusus', 500)->nullable()->index('keterampilan_khusus');
            $table->date('tgl_masuk')->index('tgl_masuk');
            $table->string('status_karyawan', 50)->nullable()->index('status_karyawan');
            $table->date('tgl_tetap')->index('tgl_tetap');
            $table->string('golongan')->nullable()->index('golongan');
            $table->string('jabatan', 50)->nullable()->index('jabatan');
            $table->string('dept', 50)->nullable()->index('dept');
            $table->string('bagian', 50)->nullable()->index('bagian');
            $table->string('atasan1', 128)->nullable()->index('atasan1');
            $table->string('atasan2', 128)->nullable()->index('atasan2');
            $table->string('no_bpjs_tk', 128)->nullable()->index('no_bpjs_tk');
            $table->string('no_bpjs_kes', 128)->nullable()->index('no_bpjs_kes');
            $table->string('status_aktif', 1)->nullable()->index('status_aktif')->comment('1 = Aktif, 2 = Tidak Aktif');
            $table->date('tgl_resign')->index('tgl_resign');
            $table->string('kode_jabatan', 10)->nullable()->index('kode_jabatan');
            $table->string('nama_jabatan')->nullable()->index('nama_jabatan');
            $table->integer('pot_cuti')->nullable();
            $table->integer('sisa_cuti')->nullable();
            $table->date('tgl_surat_resign');
            $table->string('gaji')->nullable();
            $table->string('ukuran_baju_polo')->nullable();
            $table->string('ukuran_baju_shirt')->nullable();
            $table->string('disabled_ub')->nullable();
            $table->string('kartu_keluarga')->nullable();
            $table->mediumText('ttd')->nullable();
            $table->date('masa_berlaku_ktp')->nullable();
            $table->string('RT', 10)->nullable();
            $table->string('RW', 10)->nullable();
            $table->string('status_seragam', 100)->nullable();
            $table->date('tgl_seragam')->nullable();
            $table->string('masa_kerja', 100)->nullable();
            $table->string('status_idcard', 100)->nullable();
            $table->string('sisa_cuti_th_sebelumnya', 100)->nullable();
            $table->string('tgl_generate_cuti', 100)->nullable();
            $table->string('keterangan_resign', 100)->nullable();
            $table->date('tgl_evaluasi')->nullable();
            $table->integer('status_email_kontrak')->nullable();

            $table->primary(['id', 'no_scan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_makar');
    }
};
