<?php

namespace App\Listeners;

use App\Events\CommentAdultOldEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\Employee;
use App\Notifications\CommentAdultOldNotification;


class CommentAdultOldListener
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
     * @param  CommentAdultOldEvent  $event
     * @return void
     */
    public function handle(CommentAdultOldEvent $event)
    {
      Employee::All()
            ->each(function (Employee $employee) use($event) {
                Notification::send($employee, new CommentAdultOldNotification($event->comment));
                // $query->notify(new CommentAdultOldNotification($model));
            });
    }
}
