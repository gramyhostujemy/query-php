<?php 

namespace Query\SourceEngine\DataType;

use Buffer;

final class A2S_INFO
{
    public function __construct(string $payload = "") {
        $buffer = new Buffer($payload);

        $this->protocol = $buffer->int8();
        $this->name = $buffer->string();
        $this->map = $buffer->string();
        $this->folder = $buffer->string();
        $this->game = $buffer->string();
        $this->id = $buffer->int16();
        $this->players_num = $buffer->int8();
        $this->players_max = $buffer->int8();
        $this->bots = $buffer->int8();
        $this->server_type = $buffer->char();
        switch ($this->server_type) {
            case 'd': {
                $this->server_type = "dedicated";
                break;
            }
            case 'l': {
                $this->server_type = "local";
                break;
            }
            case 'p': {
                $this->server_type = "proxy";
                break;
            }
        }
        $this->environment = $buffer->char();
        switch ($this->environment) {
            case 'l': {
                $this->environment = "linux";
                break;
            }
            case 'w': {
                $this->environment = "windows";
                break;
            }
            case 'o':
            case 'm': {
                $this->environment = "mac";
                break;
            }
        }
        $this->visibility = $buffer->int8() ? true : false;
        $this->vac = $buffer->int8() ? true : false;
        if ($this->id === 2400) {
            $this->the_ship['mode'] = $buffer->int8();
            switch ($this->the_ship['mode']) {
                case 0: {
                    $this->the_ship['mode'] = 'hunt';
                    break;
                }
                case 1: {
                    $this->the_ship['mode'] = 'elimination';
                    break;
                }
                case 2: {
                    $this->the_ship['mode'] = 'duel';
                    break;
                }
                case 3: {
                    $this->the_ship['mode'] = 'deathmatch';
                    break;
                }
                case 4: {
                    $this->the_ship['mode'] = 'vip_team';
                    break;
                }
                case 5: {
                    $this->the_ship['mode'] = 'team_elimination';
                    break;
                }
            }
            $this->the_ship['witnesses'] = $buffer->int8();
            $this->the_ship['duration'] = $buffer->int8();
        }
        $this->version = $buffer->string();
        $this->edf = $buffer->int8();
        if ($this->edf & 0x80) {
            $this->port = $buffer->int16();
        }
        if ($this->edf & 0x10) {
            $this->steam_id = $buffer->int64();
        }
        if ($this->edf & 0x40) {
            $this->proxy_port = $buffer->int16();
            $this->proxy_name = $buffer->string();
        }
        if ($this->edf & 0x20) {
            $this->keywords = $buffer->string();
        }
        if ($this->edf & 0x01) {
            $this->game_id = $buffer->int64();
        }
    }
}

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
