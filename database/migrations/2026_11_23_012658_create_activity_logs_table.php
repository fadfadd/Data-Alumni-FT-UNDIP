<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // Admin yang melakukan aktivitas
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
                
            // Nama admin saat aktivitas dilakukan
            $table->string('actor_name')->nullable();

            // Jenis aktivitas
            $table->string('action', 100);

            // Penjelasan aktivitas
            $table->text('description');

            // Data yang berkaitan dengan aktivitas
            $table->nullableMorphs('subject');

            // Detail tambahan aktivitas dalam format JSON
            $table->json('properties')->nullable();

            // Informasi teknis aktivitas
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            // Waktu aktivitas dicatat
            $table->timestamp('created_at')->useCurrent();

            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};