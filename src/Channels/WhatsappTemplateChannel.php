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

        if (method_exists($notification, 'toBuilder')) {
            $newBuilder = $notification->toBuilder();
            if (!empty($newBuilder))
                WhatsAppSdk::changeBuilder(
                    $newBuilder["id"],
                    $message["whatsapp_id"],
                    $newBuilder["resource_name"],
                    $newBuilder["state_id"],
                    $newBuilder["resource_id"]
                );
        }

        WhatsAppSdk::sendTemplate($message["whatsapp_id"], $message['localizable_params'],
            $message['id'], $message['form_template'], $message['button_params'] ?? []);
    }
}
