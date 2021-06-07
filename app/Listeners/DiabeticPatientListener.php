<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\DiabeticPatientEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\DiabeticPatient;
use App\Employee;
use App\Notifications\DiabeticPatientNotification;

class DiabeticPatientListener
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
    public function handle(DiabeticPatientEvent $event)
    {
        Employee::All()
            ->filter(function (Employee $employee) use($event) {
                return $employee->user->can('diabetes_control_access');
            })
            ->each(function (Employee $employee) use($event) {
                Notification::send($employee, new DiabeticPatientNotification($event->diabeticPatient));
            });
    }
}
