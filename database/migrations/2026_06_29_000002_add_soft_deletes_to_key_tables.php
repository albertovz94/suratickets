<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add soft deletes support to key business tables:
 * users, tickets, devices, and requests.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('requests', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
