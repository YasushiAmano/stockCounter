<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventServices
{
    public function checkEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists();
    }

    public static function joinDateAndTime($date, $time)
    {
        $join = $date . ' ' . $time;
        return Carbon::createFromFormat('Y-m-d H:i', $join);
    }
}
