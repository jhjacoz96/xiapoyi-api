<?php

namespace App\Utils;

use Carbon\Carbon;
use DateTime;

class CalAge
{
	public static function get($date_birth) {
    $year = $date_birth->year;
    $month = $date_birth->month;
    $day = $date_birth->day;
    $now = Carbon::now();

    // Calcular diferencia de meses
    $diff_month = $now->month - $date_birth->month;
    $months  = 0;
    if ($diff_month < 0) {
        $months = 12 - ($date_birth->month - $now->month);
        if ($now->day < $date_birth->day) {
          $months--;
        }
    } else if ($diff_month > 0) {
        $months = $diff_month;
        if ($now->day < $date_birth->day) {
        $months --;
        }
    }

    // Calcular diferencia de dias
    $diff_day = $now->day - $day;
    $days = 0;
    if ($diff_day < 0) {
        $days = 31 - ($day - $now->day);
    } else {
        $days = $diff_day;
    }

    $age = "A".Carbon::createFromDate($year,$month,$day)->age." "."M".$months." "."D".$days;
    return $age;
  }

}
