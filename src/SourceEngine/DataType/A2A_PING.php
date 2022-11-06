<?php 

namespace Query\SourceEngine\DataType;

use Buffer;

final class A2A_PING
{
    public function __construct(string $payload = "") {
        $buffer = new Buffer($payload);

        $this->payload = $buffer->end();
    }
}
