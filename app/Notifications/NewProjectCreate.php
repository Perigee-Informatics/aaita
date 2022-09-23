<?php

namespace App\Notifications;

use App\Models\AppClient;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewProjectCreate extends Notification
{
    use Queueable;

    private $client_name;
    private $project_id;
    public $project_status_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($item)
    {
        $this->project_id = $item->id;
        $this->client_name = AppClient::findOrFail($item->client_id)->name_en;
        $this->project_status = 1;
        
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array 
     */
    public function toDatabase($notifiable)
    {
        return [
            'client_name'=> $this->client_name,
            'project_detail' => 'New Project Demand has been Added',
            'project_id' => $this->project_id,
            'project_status' => $this->project_status,
        ];
    }
}
