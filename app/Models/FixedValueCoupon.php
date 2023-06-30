<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixedValueCoupon extends Model
{
 protected $table="fixed_value_coupons";
    public function discount($order){
        return $this->value;
    }
}
