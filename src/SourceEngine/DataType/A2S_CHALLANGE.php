<?php 

namespace Query\SourceEngine\DataType;

use Query\QueryException;
use Buffer\Reader as Buffer;

final class A2S_CHALLANGE
{
    public function __construct(string $payload = "") {
        $buffer = new Buffer($payload);

        $this->challange = $buffer->bytes(4);
        if (!$this->challange) {
            throw new QueryException("Błędna wartość challange");
        }
    }
}
