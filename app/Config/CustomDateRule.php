<?php

namespace Config;

use CodeIgniter\I18n\Time;

class CustomDateRule
{
    public function date_valid(string $date)
    {
        $d = Time::createFromFormat('YYYY-MM-DD', $date);
        return $d && $d->format('YYYY-MM-DD') === $date;
    }
}