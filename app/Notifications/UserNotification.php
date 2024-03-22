<?php

namespace App\Notifications;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $user;
    private $notifiedUser;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, User $notifiedUser)
    {
        $this->user = $user;
        $this->notifiedUser = $notifiedUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
       return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
            return [
                'id'=>$this->notifiedUser->id,
                'name' => $this->user->name,
                'image'=>$this->user->image,
                'username'=>$this->user->username,
                'created_at'=>now()
            ];
    }

    public function broadcastType()
    {
        return 'new-request';
    }
}
