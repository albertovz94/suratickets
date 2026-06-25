<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateRoleEnum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-role-enum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the role enum in users table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'usuario', 'outsourcing') DEFAULT 'usuario'");
            $this->info('Role enum updated successfully.');
        } catch (\Exception $e) {
            $this->error('Failed: ' . $e->getMessage());
        }
    }
}
