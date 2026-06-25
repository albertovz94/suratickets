<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = ['Andinka', 'Kikana', 'Nabilka', 'distribucion', 'Galpon', 'Hiper Suraki', '2kNR', 'Lacteos', 'Surakarne americas'];
        foreach ($branches as $branch) {
            \App\Models\Branch::firstOrCreate(['name' => $branch]);
        }
    }
}
