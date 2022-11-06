<?php 

namespace Query\SourceEngine\DataType;

use Buffer\Reader as Buffer;

final class A2S_INFO_OLD
{
    public function __construct(string $payload = "") {
        $buffer = new Buffer($payload); // 6d

        $this->address = $buffer->string();
        $this->name = $buffer->string();
        $this->map = $buffer->string();
        $this->folder = $buffer->string();
        $this->game = $buffer->string();
        $this->players_num = $buffer->int8();
        $this->players_max = $buffer->int8();
        $this->protocol = $buffer->int8();
        $this->server_type = $buffer->bytes(1);
        $this->environment = $buffer->bytes(1);
        $this->visibility = $buffer->int8();
        $this->mod = $buffer->int8();
        if ($this->mod) {
            $this->link = $buffer->string();
            $this->downloaded_link = $buffer->string();
            $this->null = $buffer->bytes(1);
            $this->version = $buffer->int32();
            $this->size = $buffer->int32();
            $this->type = $buffer->int8();
            $this->dll = $buffer->int8();
        }
        $this->vac = $buffer->int8();
        $this->bots = $buffer->int8();
    }
}
