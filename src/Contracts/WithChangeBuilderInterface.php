<?php

namespace Kalberfon\TakeSdkLaravel\Contracts;

interface WithChangeBuilderInterface
{
    public function toBuilder(): array;
}
