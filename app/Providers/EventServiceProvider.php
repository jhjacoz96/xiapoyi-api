<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\CommentAdultOldEvent;
use App\Listeners\CommentAdultOldListener;
use App\Events\FileClinicalObstetricEvent;
use App\Listeners\FileClinicalObstetricListener;
use App\Events\DiabeticPatientEvent;
use App\Listeners\DiabeticPatientListener;
use App\Events\PostGlucoseEvent;
use App\Listeners\PostGlucoseListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CommentAdultOldEvent::class => [
            CommentAdultOldListener::class,
        ],
        DiabeticPatientEvent::class => [
            DiabeticPatientListener::class,
        ],
        FileClinicalObstetricEvent::class => [
            FileClinicalObstetricListener::class,
        ],
        PostGlucoseEvent::class => [
            PostGlucoseListener::class,
        ],
        /*'App\Events\CommentAdultOldEvent' => [
            'App\Listeners\CommentAdultOldListener',
        ],*/
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
