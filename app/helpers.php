<?php
     function presentPrice($price){
        $english_format_number = number_format($price);
        return  $english_format_number;
    }
    function setActiveCategory($category,$output='active'){
  return request()->category ==$category ? $output:'';
    }