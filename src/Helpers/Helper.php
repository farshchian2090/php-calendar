<?php

namespace OpenModule\PhpCalendar\Helpers;

class Helper
{
    public static function option($array, $key, $default){
        return $array[$key] ?? $default;
    }
}
