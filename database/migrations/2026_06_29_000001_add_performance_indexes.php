<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add missing indexes to frequently queried columns
 * for improved query performance in production.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->index('creator_id');
            $table->index('assigned_to');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['creator_id']);
            $table->dropIndex(['assigned_to']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
        });
    }
};
