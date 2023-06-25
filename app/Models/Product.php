<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function presentPrice(){
        $english_format_number = number_format($this->price);
        return  $english_format_number;
    }
    public function scopeMightAlsoLike($query){
        return $query->inRandomOrder()->take(4);
    }
}
