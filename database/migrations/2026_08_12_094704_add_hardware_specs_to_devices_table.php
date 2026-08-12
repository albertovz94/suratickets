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
        Schema::table('devices', function (Blueprint $table) {
            $table->string('ram')->nullable()->after('specs');
            $table->string('cpu')->nullable()->after('ram');
            $table->string('cpu_generation')->nullable()->after('cpu');
            $table->string('storage')->nullable()->after('cpu_generation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn(['ram', 'cpu', 'cpu_generation', 'storage']);
        });
    }
};
