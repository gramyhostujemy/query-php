<?php 

namespace Query\SourceEngine\DataType;

use Buffer\Reader as Buffer;

final class A2S_PLAYER
{
    public function __construct(string $payload = "") {
        $buffer = new Buffer($payload);

        $this->players_num = $buffer->int8();
        for ($i = 0; $i < $this->players_num; $i++) {
            $this->players[$i]->index = $buffer->int8();
            $this->players[$i]->name = $buffer->string();
            $this->players[$i]->score = $buffer->int32();
            $this->players[$i]->duration = $buffer->float32();
            if ($this->data['id'] === 2400) {
                $this->players[$i]->deaths = $buffer->int32();
                $this->players[$i]->money = $buffer->int32();
            }
        }
    }
}
