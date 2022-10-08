<?php

namespace Kalberfon\TakeSdkLaravel;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Ramsey\Uuid\Uuid;

/**
 *
 */
class WhatsAppService
{
    private $baseUrl;
    private $key;
    private $namespace;
    private $client;
    /**
     * @param string $baseUrl
     * @param string $key
     * @param string $namespace
     */
    public function __construct(string $baseUrl, string $key, string $namespace)
    {
        $this->baseUrl = $baseUrl;
        $this->key = $key;
        $this->namespace = $namespace;
    }
    /**
     * @param string $key
     * @return void
     */
    public function setKey(string $key) {
        $this->key = $key;
    }
    /**
     * @param string $endpoint
     * @param array $params
     * @throw \Exception
     * @return array|null
     */
    private function callService(string $endpoint, array $params = [])
    {
        $client = new Client([
            RequestOptions::HEADERS => [
                "Authorization" => "Key {$this->key}"
            ]
        ]);
        $response = $client->post("{$this->baseUrl}{$endpoint}", [
            RequestOptions::JSON => $params
        ]);

        if ($response->getStatusCode() > 400) {
            throw new \Exception(__("response request code ({$response->getStatusCode()})"));
        }
        return json_decode($response->getBody()->getContents(), TRUE) ?? NULL;
    }

    /**
     * @param $whatsId
     * @param $localizableParams
     * @param $id
     * @param $templateId
     * @return array|null
     */
    public function sendMessage($whatsId, $localizableParams, $id, $templateId)
    {
        $params = [
            'id' => $id,
            'to' => $whatsId,
            'type' => 'application/json',
            'content' => [
                'type' => 'hsm',
                'hsm' => [
                    'namespace' => $this->namespace,
                    'element_name' => $templateId,
                    'language' => [
                        'policy' => 'deterministic',
                        'code' => 'pt_BR',
                    ],
                    'localizable_params' => $localizableParams
                ]
            ]
        ];
        return $this->callService('/messages', $params);
    }

    /**
     * @param $whatsId
     * @param $localizableParams
     * @param $id
     * @param $templateId
     * @param array $buttonParams
     * @return array|null
     */
    public function sendTemplate($whatsId, $localizableParams, $id, $templateId, array $buttonParams = []): ?array
    {
        $components = [
            [
                "type" => "body",
                "parameters" => $localizableParams
            ]
        ];
        if (!empty($anotherComponentParams)) {
            $components[] = array_merge([
                "type" => "button"
            ], $buttonParams);
        }
        $params = [
            'id' => $id,
            'to' => $whatsId,
            'type' => 'application/json',
            'content' => [
                'type' => 'template',
                'template' => [
                    'namespace' => $this->namespace,
                    'name' => $templateId,
                    'language' => [
                        'code' => 'pt_BR',
                        'policy' => 'deterministic',
                    ],
                    'components' => $components
                ]
            ]
        ];
        return $this->callService('/messages', $params);
    }
    public function changeBuilder(string $id, string $whatsappId, string $resourceName, string $stateId, string $resourceId): void
    {
        $changeBuilderMasterBody = [
            "id" => $id,
            "method" => "set",
            "uri" => "/contexts/{$whatsappId}/Master-State",
            "type" => "text/plain",
            "resource" => "{$resourceName}@msging.net"
        ];
        $this->callService("/commands", $changeBuilderMasterBody);
        /**
         * Set builder and first item
         */
        $changeBuilderAndStartIn = [
            "id" => $id,
            "method" => "set",
            "uri" => "/contexts/{$whatsappId}/stateid@{$stateId}",
            "type" => "text/plain",
            "resource" => $resourceId
        ];
        $this->callService("/commands", $changeBuilderAndStartIn);
    }
    /**
     * @param string $phone
     * @param string $id
     */
    public function getWhatsappId(string $phone, string $id)
    {
        $params = [
            'id' => $id,
            'to' => 'postmaster@wa.gw.msging.net',
            'method' => 'get',
            'uri' => 'lime://wa.gw.msging.net/accounts/+55' . $phone,
        ];
        $response = $this->callService("/commands", $params);

        if (!empty($response) and $response['status'] == 'success') {
            return $response['resource']['identity'];
        }

        return "";
    }
}
