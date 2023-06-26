<?php
     function presentPrice($price){
        $english_format_number = number_format($price);
        return  $english_format_number;
    }