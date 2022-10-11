<?php

namespace Kalberfon\TakeSdkLaravel\Events;

class MessageSentTrigger
{
    public $template;
    public $identity;
    public $messageId;
    public $sentAt;

    public function __construct(string $template, string $identity, string $messageId)
    {
        $this->template = $template;
        $this->identity = $identity;
        $this->messageId = $messageId;
        $this->sentAt = date('Y-m-d H:i:s');
    }
}
