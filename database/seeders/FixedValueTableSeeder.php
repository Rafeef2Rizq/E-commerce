<?php

namespace Database\Seeders;

use App\Models\FixedValueCoupon;

use Illuminate\Database\Seeder;

class FixedValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FixedValueCoupon::create([
            'value' => 3000,
           
        ]);
    }
}
