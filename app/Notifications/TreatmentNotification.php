<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\PatientTreatment;
use Carbon\Carbon;


class TreatmentNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Array $treatment)
    {
        $this->treatment = $treatment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {   
        $comment = [
            "count" => count($this->treatment["event"]),
            "message" => count($this->treatment["event"]) == 1 ? "medicamento" : "medicamentos",
            "assign" => count($this->treatment["event"]) == 1 ? "asignado" : "asignados",
        ];
        return [
            'comment' => $comment["count"] ." ". $comment["message"] ." ". $comment["assign"] . " a su tratamiento farmacológico",
            'type_notification' => 'new_medicine',
            'time' => Carbon::now(),
        ];
    }
}
