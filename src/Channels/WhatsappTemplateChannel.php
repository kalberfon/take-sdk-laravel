<?php

namespace Kalberfon\TakeSdkLaravel\Channels;


use Kalberfon\TakeSdkLaravel\Facades\WhatsAppSdk;
use Kalberfon\TakeSdkLaravel\Contacts\WithChangeBuilderInterface;

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

        if ($notification instanceof WithChangeBuilderInterface) {
            $newBuilder = $notification->toBuilder();
            WhatsAppSdk::changeBuilder(
                $message["whatsapp_id"], 
                $message["resource_name"],
                $message["state_id"],
                $message["resource_id"]
            );
        }

        WhatsAppSdk::sendTemplate($message["whatsapp_id"], $message['localizable_params'],
            $message['id'], $message['form_template'], $message['button_params'] ?? []);
    }
}
