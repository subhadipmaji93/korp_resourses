<?php
namespace App\Libraries;
use CodeIgniter\I18n\Time;

class CheckDateBefore
{
    public static function check($time1, $time2){
        $time1 = Time::parse($time1);
        $time2 = Time::parse($time2);

        return $time1->isBefore($time2);
    }
}
?>