<?php 

namespace Query\Minecraft\DataType;

use Helpers\Buffer;

final class INFO
{
    public $players = [];

    public function __construct(string $payload = "") {
        $buffer = new Buffer($payload);
        $buffer->increase(5);

        $action = $buffer->string();

        $unknown[] = $buffer->int16(); // 0x0080
        for ($i = 0; $i < 10; $i++) {
            $key = $buffer->string();
            $value = $buffer->string();
            $this->{$key} = $value;
        }
        $unknown[] = $buffer->int16(); // 0x0100

        $players_ = $buffer->string();
        $unknown[] = $buffer->int8(); // 0x00 ?
        for ($i = 0; $i < $this->numplayers; $i++) {
            $this->players[] = $buffer->string();
        }
        $unknown[] = $buffer->int8(); // 0x00 ?
    }
}
