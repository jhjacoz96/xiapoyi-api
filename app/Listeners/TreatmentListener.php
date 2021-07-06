<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\TreatmentEvent;
use Illuminate\Support\Facades\Notification;
use App\DiabeticPatient;
use App\Notifications\TreatmentNotification;

class TreatmentListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TreatmentEvent $event)
    {
        $patient = DiabeticPatient::find($event->treatment["diabetic_patient"]["id"]);
        $object = [
            "event" => $event->treatment["id_medicines"],
        ];
        Notification::send($patient, new TreatmentNotification($object));
    }
}
