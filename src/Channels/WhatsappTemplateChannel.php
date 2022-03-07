<?php

namespace Kalberfon\TakeSdkLaravel\Channels;


use Kalberfon\TakeSdkLaravel\Facades\WhatsAppSdk;

class WhatsappTemplateChannel
{
    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, \Illuminate\Notifications\Notification $notification)
    {
        $message = $notification->toWhatsapp($notifiable);

        WhatsAppSdk::sendTemplate($message["whatsapp_id"], $message['localizable_params'],
            $message['id'], $message['form_template']);

    }
}
