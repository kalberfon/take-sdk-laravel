<?php

namespace Kalberfon\TakeSdkLaravel\Facades;


use Kalberfon\TakeSdkLaravel\WhatsAppService;

/**
 * @method bool sendMessage($whatsId, $localizableParams, $id, $templateId)
 * @method string getWhatsappId(string $phone, string $id)
 * @method array sendTemplate($whatsId, $localizableParams, $id, $templateId, $buttonParams = [])
 * @method void changeBuilder(string $id, string $whatsappId, string $resourceName, string $stateId, string $resourceId)
 */

class WhatsAppSdk
{
    /**
     * @param $name
     * @return mixed
     */
    protected static function resolveFacade($name)
    {
        return app()[$name];
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return (self::resolveFacade(WhatsAppService::class))->$name(...$arguments);
    }
}
