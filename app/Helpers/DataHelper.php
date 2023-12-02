<?php

namespace App\Helpers;

class DataHelper{

    public static function convertTanggal($date){
        return date('d-M-Y', strtotime($date));
    }

    public static function nextWeek($date){
        return date('Y-m-d', strtotime($date . '+7 days'));
    }

}