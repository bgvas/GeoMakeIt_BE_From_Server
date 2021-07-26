<?php

namespace App\Notifications;

use App\Models\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public const TYPE_DEFAULT = 'default';
    public const TYPE_SUCCESS = 'success';
    public const TYPE_ERROR = 'error';
    public const TYPE_WARNING = 'warning';
    public const TYPE_INFO = 'info';
    public const TYPE_QUESTION = 'question';

    public $title;
    public $message;
    public $notification_type;
    public $redirect_url;

    /**
     * Create a new notification instance.
     *
     * @param string|null $title
     * @param string|null $message
     * @param string $notification_type
     * @param string|null $redirect_url
     */
    public function __construct(string $title = null, string $message = null, string $notification_type = self::TYPE_DEFAULT, string $redirect_url = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->notification_type = in_array($notification_type, $this->getTypes()) ? $notification_type : self::TYPE_DEFAULT;
        $this->redirect_url = $redirect_url;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'notification_type' => $this->notification_type,
            'redirect_url' => $this->redirect_url,
        ];
    }

    public function getTypes() {
        return [
            self::TYPE_DEFAULT, self::TYPE_SUCCESS, self::TYPE_ERROR,
            self::TYPE_WARNING, self::TYPE_INFO, self::TYPE_QUESTION,
        ];
    }

    public function broadcastType() {
        return 'notifications';
    }
}
