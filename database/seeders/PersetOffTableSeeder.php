<?php

namespace Database\Seeders;

use App\Models\PersentOffCoupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersetOffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PersentOffCoupon::create([
            'persent_off' => 50,
           
        ]);
    }
}
