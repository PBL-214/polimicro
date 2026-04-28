<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Prodi Mikro
        Schema::create('prodi_mikro', function (Blueprint $table) {
            $table->id();
            $table->string('kode_prodi', 20)->unique();
            $table->string('nama_prodi', 100);
            $table->text('deskripsi')->nullable();
            $table->string('durasi', 50)->nullable();
            $table->string('icon', 10)->default('📚');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->foreignId('nid')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Makul (Mata Kuliah)
        Schema::create('makul', function (Blueprint $table) {
            $table->id();
            $table->string('kode_makul', 20)->unique();
            $table->string('nama_makul', 100);
            $table->text('deskripsi')->nullable();
            $table->integer('sks')->default(3);
            $table->foreignId('prodi_id')->constrained('prodi_mikro')->cascadeOnDelete();
            $table->foreignId('dosen_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // Materi
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_materi', 20)->unique();
            $table->string('nama_materi', 100);
            $table->text('deskripsi_materi')->nullable();
            $table->string('file_materi', 255)->nullable();
            $table->foreignId('makul_id')->constrained('makul')->cascadeOnDelete();
            $table->timestamps();
        });

        // Tugas
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tugas', 20)->unique();
            $table->string('nama_tugas', 100);
            $table->text('deskripsi_tugas')->nullable();
            $table->string('format_file', 50)->nullable();
            $table->integer('max_nilai')->default(100);
            $table->date('tanggal_awal_deadline')->nullable();
            $table->date('tanggal_akhir_deadline')->nullable();
            $table->foreignId('materi_id')->nullable()->constrained('materi')->nullOnDelete();
            $table->foreignId('makul_id')->constrained('makul')->cascadeOnDelete();
            $table->timestamps();
        });

        // Pengerjaan Tugas (Submissions)
        Schema::create('pengerjaan_tugas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tugas_id')->constrained('tugas')->cascadeOnDelete();
            $table->string('file_dikumpul', 255)->nullable();
            $table->datetime('waktu_kumpul')->nullable();
            $table->decimal('nilai', 5, 2)->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
        });

        // Views Materi (tracking akses)
        Schema::create('views_materi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('materi_id')->constrained('materi')->cascadeOnDelete();
            $table->datetime('waktu_akses_materi')->nullable();
            $table->datetime('waktu_selesai_materi')->nullable();
            $table->timestamps();
        });

        // Pendaftaran (Enrollment) - TABEL BARU
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('prodi_id')->constrained('prodi_mikro')->cascadeOnDelete();
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->date('registered_at')->nullable();
            $table->timestamps();
        });

        // Sertifikat - TABEL BARU
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('prodi_id')->constrained('prodi_mikro')->cascadeOnDelete();
            $table->string('nomor_sertifikat', 50)->unique();
            $table->date('tanggal_terbit');
            $table->enum('status', ['diterbitkan', 'dicabut'])->default('diterbitkan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
        Schema::dropIfExists('pendaftaran');
        Schema::dropIfExists('views_materi');
        Schema::dropIfExists('pengerjaan_tugas');
        Schema::dropIfExists('tugas');
        Schema::dropIfExists('materi');
        Schema::dropIfExists('makul');
        Schema::dropIfExists('prodi_mikro');
    }
};
