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
        Schema::create('permohonan_izin_cuti', function (Blueprint $table) {
            $table->integer('id', true)->index('id');
            $table->string('kode_cuti', 12)->nullable()->index('kode_cuti');
            $table->integer('nip')->nullable()->index('nip');
            $table->string('dept', 5)->nullable()->index('dept');
            $table->string('pengganti_kerja', 30)->nullable()->index('pengganti_kerja');
            $table->string('lama_izin', 3)->nullable()->index('lama_izin');
            $table->string('saldo_cuti', 3)->nullable();
            $table->string('days_or_month', 5)->nullable()->index('days_or_year');
            $table->date('tgl_mulai')->nullable()->index('tgl_mulai');
            $table->date('tgl_selesai')->nullable()->index('tgl_selesai');
            $table->string('ket', 100)->nullable()->index('ket');
            $table->string('dll')->nullable()->index('dll');
            $table->string('alasan', 200)->nullable()->index('alasan');
            $table->string('pemohon_nama', 30)->nullable()->index('pemohon_nama');
            $table->string('pemohon_jabatan', 30)->nullable()->index('pemohon_jabatan');
            $table->string('disetujui_nama_1', 30)->nullable()->index('disetujui_nama_1');
            $table->string('disetujui_jabatan_1', 30)->nullable()->index('disetujui_jabatan_1');
            $table->string('disetujui_nama_2', 30)->nullable()->index('disetujui_nama_2');
            $table->string('disetujui_jabatan_2', 30)->nullable()->index('disetujui_jabatan_2');
            $table->string('mengetahui_nama', 30)->nullable()->index('mengetahui_nama');
            $table->string('mengetahui_jabatan', 30)->nullable()->index('mengetahui_jabatan');
            $table->date('tgl_surat_pemohon')->nullable()->index('tgl_surat_pemohon');
            $table->date('tgl_diset_mengetehui')->nullable()->index('tgl_diset_mengetehui');
            $table->string('status')->nullable()->index('status');

            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permohonan_izin_cuti');
    }
};
