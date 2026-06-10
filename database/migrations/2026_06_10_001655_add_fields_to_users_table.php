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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable();
            $table->foreignId('sucursal_id')->nullable()->constrained('sucursales')->nullOnDelete();
            $table->enum('rol', ['admin', 'usuario'])->default('usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['sucursal_id']);
            $table->dropColumn(['sucursal_id', 'rol']);
        });
    }
};
