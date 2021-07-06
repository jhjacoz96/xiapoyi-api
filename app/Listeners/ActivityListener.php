<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\DiabeticPatient;
use App\Notifications\ActivityNotification;
use App\Events\ActivityEvent;
use Illuminate\Support\Facades\Notification;
class ActivityListener
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
    public function handle(ActivityEvent $event)
    {
        $patient = DiabeticPatient::find($event->treatment["diabetic_patient"]["id"]);
        $object = [
            "event" => $event->treatment["id_activities"],
        ];
        Notification::send($patient, new ActivityNotification($object));
    }
}
