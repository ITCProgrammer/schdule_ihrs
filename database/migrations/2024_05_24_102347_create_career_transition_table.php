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
        Schema::create('career_transition', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('no_scan')->nullable();
            $table->string('proses')->nullable();
            $table->string('tgl_efektif')->nullable();
            $table->string('dept_lama')->nullable();
            $table->string('dept_baru')->nullable();
            $table->string('bagian_lama')->nullable();
            $table->string('bagian_baru')->nullable();
            $table->string('golongan_lama')->nullable();
            $table->string('golongan_baru')->nullable();
            $table->string('jabatan_lama')->nullable();
            $table->string('jabatan_baru')->nullable();
            $table->string('kode_jabatan_baru')->nullable();
            $table->string('kode_jabatan_lama', 100)->nullable();
            $table->string('atasan1')->nullable();
            $table->string('atasan2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('career_transition');
    }
};
