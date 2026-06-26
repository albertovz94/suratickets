<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->text('admin_note')->nullable()->after('status');
            $table->string('proof_photo_path')->nullable()->after('admin_note');
        });

        // Actualizar el estado 'aprobado' a 'en_proceso' en los registros existentes
        DB::table('requests')->where('status', 'aprobado')->update(['status' => 'en_proceso']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir el estado si se vuelve atrás
        DB::table('requests')->where('status', 'en_proceso')->update(['status' => 'aprobado']);

        Schema::table('requests', function (Blueprint $table) {
            $table->dropColumn(['admin_note', 'proof_photo_path']);
        });
    }
};
