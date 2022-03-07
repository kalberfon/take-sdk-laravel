<?php

namespace Kalberfon\TakeSdkLaravel\Tests;

use Faker\Provider\Uuid;
use Kalberfon\TakeSdkLaravel\WhatsAppService;

class ExampleTest extends TestCase
{

    public function testExample()
    {
        $service = new WhatsAppService("http://test.com", "----- test key ------", "------ namespace test ----");
        $messageId = Uuid::uuid();
        $ret = $service->sendTemplate("554855515101@wa.gw.msging.net", [
            [
                "type" => "text",
                'text' => "teste",
            ]
        ], $messageId, "template");
        $this->assertArrayHasKey("id", $ret);
        $this->assertArrayHasKey("type", $ret);
        $this->assertArrayHasKey("to", $ret);
        $this->assertArrayHasKey("content", $ret);
    }
}
