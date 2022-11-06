<?php 

namespace Query\SourceEngine\Mapper;

use Query\SourceEngine\DataType;

final class A2S_INFO_OLD
{
    public function __construct(string $payload = "") {
        $data = new DataType\A2S_INFO_OLD($payload);

        $this->game = $data->folder;
        $this->mode = $data->game;
        $this->name = $data->name;
        $this->map = $data->map;
        $this->players_num = $data->players_num;
        $this->players_max = $data->players_max;
    }
}
