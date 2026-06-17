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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->foreignId('sucursal_id')->constrained('sucursales')->cascadeOnDelete();
            $table->string('area_departamento');
            $table->string('equipo_afectado');
            $table->enum('priority', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->enum('status', ['abierto', 'asignado', 'en_proceso', 'pendiente', 'resuelto', 'cerrado'])->default('abierto');
            $table->foreignId('creator_id')->constrained('users');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->text('resolution_summary')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
