<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Forum Discussions
        Schema::create('forum_discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('makul_id')->constrained('makul')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title', 200);
            $table->text('body');
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();
        });

        // Forum Replies
        Schema::create('forum_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained('forum_discussions')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->foreignId('parent_id')->nullable()->constrained('forum_replies')->cascadeOnDelete();
            $table->timestamps();
        });

        // Announcements
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('makul_id')->nullable()->constrained('makul')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('title', 200);
            $table->text('body');
            $table->boolean('is_global')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // Attendances (sesi absensi)
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('makul_id')->constrained('makul')->cascadeOnDelete();
            $table->integer('pertemuan_ke');
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });

        // Attendance Records (record per mahasiswa)
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_id')->constrained('attendances')->cascadeOnDelete();
            $table->foreignId('mahasiswa_id')->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('alpha');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('forum_replies');
        Schema::dropIfExists('forum_discussions');
    }
};
