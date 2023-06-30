<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersentOffCoupon extends Model
{
    protected $table="persent_off_coupons";

    use HasFactory;
    public function discount($order){
        return round(($this->persent_off/100)*$order);
    }
}
