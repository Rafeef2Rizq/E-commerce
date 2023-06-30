<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public static function findByCode($code){
        return self::where('code',$code)->first();
    }
    public function coupon(){
        return  $this->morphTo();
    }
    public function discount($order){
return $this->coupon->discount($order);
    }
}
