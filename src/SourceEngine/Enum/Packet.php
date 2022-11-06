<?php 

namespace Query\SourceEngine\Enum;

final class Packet
{
    const SINGLE = "\xFF\xFF\xFF\xFF";
    const MULTI = "\xFE\xFF\xFF\xFF";

    const A2S_INFO = "\x54";
    const A2S_PLAYER = "\x55";
    const A2S_RULES = "\x56";
    const A2A_PING = "\x69";

    const A2S_CHALLANGE_RESPONSE = "\x41";
    const A2S_INFO_RESPONSE = "\x49";
    const A2S_INFO_OLD_RESPONSE = "\x6D";
    const A2S_PLAYER_RESPONSE = "\x44";
    const A2S_RULES_RESPONSE = "\x45";
    const A2A_PING_RESPONSE = "\x6A";

    const QUERY = "Source Engine Query\x00";
}
