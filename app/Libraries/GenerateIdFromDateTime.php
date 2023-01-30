<?php

namespace App\Libraries;

class GenerateIdFromDateTime
{
    public static function generate($date, $time){
        $date = str_replace('-', '', $date);
        $time = str_replace(':', '', $time);

        return join([$date,$time]);
    }
}
?>