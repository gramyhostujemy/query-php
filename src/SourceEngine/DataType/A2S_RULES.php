<?php 

namespace Query\SourceEngine\DataType;

use Buffer\Reader as Buffer;

final class A2S_RULES
{
    public function __construct(string $payload = "") {
        $buffer = new Buffer($payload);

        $rules_num = $buffer->int16();
        for ($i = 0; $i < $rules_num; $i++) {
            $name = $buffer->string();
            $value = $buffer->string();
            $this->rules[$name] = $value;
        }
    }
}
