<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\PostGlucoseEvent;
use Illuminate\Support\Facades\Notification;
use App\Employee;
use App\Notifications\PostGlucoseNotification;

class PostGlucoseListener
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
    public function handle(PostGlucoseEvent $event)
    {
        Employee::All()
           ->filter(function (Employee $employee) use($event) {
                return $employee->user->can('obstetrics_access');
            })
            ->each(function (Employee $employee) use($event) {
                Notification::send($employee, new PostGlucoseNotification($event->registerGlucose));
            });
    }
}
