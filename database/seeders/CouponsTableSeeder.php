<?php

namespace Database\Seeders;


use App\Models\Coupon;

use Illuminate\Database\Seeder;


class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'ABC123',
            'coupon_type' => 'App\Models\FixedValueCoupon',
            'coupon_id' => 1,
        ]);
        Coupon::create([
            'code' => 'CD22',
            'coupon_type' => 'App\Models\PersentOffCoupon',
            'coupon_id' => 1,
        ]);

        // Coupon::create([
        //     'code' => 'DEF456',
        //     'type' => 'percent',
        //     'percent_off' => 50,
        // ]);
    }
}
