<?php

namespace App\Listeners;

use App\Events\FileClinicalObstetricEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Employee;
use App\Pregnant;
use App\Notifications\FileClinicalObstetricNotification;

class FileClinicalObstetricListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(FileClinicalObstetricEvent $event)
    {
         Employee::All()
            ->filter(function (Employee $employee) use($event) {
                if (
                    $employee->user->can('obstetrics_access') &&
                    \Auth::user()->employee->id != $employee->id
                   )
                return $employee->user->can('obstetrics_access');
            })
            ->each(function (Employee $employee) use($event) {
                Notification::send($employee, new FileClinicalObstetricNotification($event->pregnant));
            });
           /* foreach ($employees as $key => $employee) {
                 Notification::send($employee, new FileClinicalObstetricNotification($event->pregnant));
            }*/
    }
}
