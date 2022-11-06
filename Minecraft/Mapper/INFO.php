<?php 

namespace Query\Minecraft\Mapper;

use Query\Minecraft\DataType;

final class INFO
{
    public function __construct(string $payload = "") {
        $data = new DataType\INFO($payload);

        $this->game = strtolower($data->game_id);
        $this->mode = $this->resolveGameType($data->gametype) . " " . $this->parsePlugins($data->plugins)['version'];
        $this->name = $data->hostname;
        $this->map = $data->map;
        $this->players_num = (int)$data->numplayers;
        $this->players_max = (int)$data->maxplayers;
    }

    private function parsePlugins($plugins = ""): array {
        [$mod, $plugins] = explode(": ", $plugins);
        [$mod, $modVersion] = explode(" on ", $mod);
        $plugins = explode("; ", $plugins);

        return [
            "mod" => $mod,
            "version" => explode("-", $modVersion)[0],
            "plugins" => $plugins,
        ];
    }

    private function resolveGameType(string $gameType = "") {
        switch ($gameType) {
            case 'SMP': {
                return "Survival";
            }
        }
        return $gameType;
    }
}
