<?php
namespace Kalberfon\TakeSdkLaravel;

use Illuminate\Support\ServiceProvider;
use Kalberfon\TakeSdkLaravel\Channels\WhatsappTemplateChannel;

class Provider extends ServiceProvider
{
    public function boot()
    {
        $this->app->singleton(WhatsAppService::class, function () {
            return (new WhatsAppService(
                config('services.whatsapp.base_url'),
                config('services.whatsapp.key'),
                config('services.whatsapp.namespace')
            ));
        });
        $this->app->bind("wa-template", WhatsappTemplateChannel::class);
    }
}
