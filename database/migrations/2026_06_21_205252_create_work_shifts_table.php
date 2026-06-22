<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            
            // Horas planificadas (asignadas previamente)
            $table->time('scheduled_start')->nullable();
            $table->time('scheduled_end')->nullable();
            
            // Horas reales (cuando hace check-in y check-out)
            $table->timestamp('check_in')->nullable();
            $table->timestamp('check_out')->nullable();
            
            $table->enum('status', ['programado', 'en_curso', 'completado', 'ausente', 'cancelado'])->default('programado');
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shifts');
    }
};
