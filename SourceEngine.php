<?php 

namespace Query;

use Socket;
use Query\SourceEngine\Enum;
use Query\SourceEngine\Mapper;
use Query\SourceEngine\DataType;
use Helpers\Buffer;
use Helpers\Dump;

class SourceEngine {
    private $udp;
    private $ip;
    private $port;

    public $data;

    public function __construct(string $ip = "127.0.0.1", int $port = 27015) {
        $this->udp = new Socket\UDP($ip, $port);

        $this->ip = $ip;
        $this->port = $port;

		$this->info();
		// $this->players();
		// $this->rules();

        $this->data = array_merge(
            (array)$this->info,
            // (array)$this->players,
            // (array)$this->rules,
        );
    }

    private function parse(string $header = "", string $payload = ""): object {
        switch ($header) {
            case Enum\Packet::A2S_CHALLANGE_RESPONSE: {
                return new DataType\A2S_CHALLANGE($payload);
            }
            case Enum\Packet::A2S_PLAYER_RESPONSE: {
                return new DataType\A2S_PLAYER($payload);
            }
            case Enum\Packet::A2S_RULES_RESPONSE: {
                return new DataType\A2S_RULES($payload);
            }
            case Enum\Packet::A2S_INFO_RESPONSE: {
                return new Mapper\A2S_INFO($payload);
            }
            case Enum\Packet::A2A_PING_RESPONSE: {
                return new DataType\A2A_PING($payload);
            }
            default: {
                return (object)[];
            }
        }
    }

    private function send(string $message = "") {
        $this->udp->send(
            $this->ip,
            $this->port,
            $message
        );
        
        $this->udp->receive($this->ip, $this->port);

        $buffer = new Buffer($this->udp->response);

        $type = $buffer->bytes(4);

        switch ($type) {
            case Enum\Packet::SINGLE: {
                $header = $buffer->bytes(1);
                $payload = $buffer->end();

                return $this->parse($header, $payload);
            }
            case Enum\Packet::MULTI: { // TODO: Fix and optimize
                $id = $buffer->int32();
                $packets = $buffer->int8();
                if ($id & 0x80000000) {
                    $uncompressedSize = $buffer->int32();
                    $crc32sum = $buffer->int32();
                }
                $payload = $buffer->end();

                for ($i = 1; $i < $packets; $i++) {
                    $this->udp->receive();
                    $buffer = new Buffer($this->udp->response);
                    $type = $buffer->bytes(4);
                    $id = $buffer->int32();
                    $unknown = $buffer->int8();
                    $payload .= $buffer->end();
                }

                $buffer = new Buffer($payload);
                $type = $buffer->bytes(4);
                $header = $buffer->bytes(1);
                $payload = $buffer->end();

                return $this->parse($header, $payload);
            }
        }

        throw new QueryException("Unknown response type");
    }

    private function challange(string $header = "\x00"): object {
        return $this->send(Enum\Packet::SINGLE . $header . Enum\Packet::QUERY);
    }

    private function info(): void {
        $response = $this->challange(Enum\Packet::A2S_PLAYER);
        $this->info = $this->send(Enum\Packet::SINGLE . Enum\Packet::A2S_INFO . Enum\Packet::QUERY . $response->challange);
    }
    
    private function players(): void {
        $response = $this->challange(Enum\Packet::A2S_PLAYER);
        $this->players = $this->send(Enum\Packet::SINGLE . Enum\Packet::A2S_PLAYER . $response->challange);
    }

    private function rules(): void {
        $response = $this->challange(Enum\Packet::A2S_RULES);
        $this->rules = $this->send(Enum\Packet::SINGLE . Enum\Packet::A2S_RULES . $response->challange);
    }

    private function ping(): void {
        $this->ping = $this->send(Enum\Packet::SINGLE . Enum\Packet::A2A_PING);
    }
}
