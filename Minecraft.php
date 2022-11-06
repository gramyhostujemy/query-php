<?php 

namespace Query;

use Socket;

class Minecraft
{
    private $udp;
    private $ip;
    private $port;

    public $data;

    public function __construct($ip, $port) {
        $this->udp = new Socket\UDP($ip, $port);

        $this->ip = $ip;
        $this->port = $port;

		$this->info();

        $this->data = $this->info;
    }

    public function getChallange() {
        $this->udp->send($this->ip, $this->port, "\xFE\xFD\x09\x01\x02\x03\x04");
        $this->udp->receive($this->ip, $this->port);

        return pack('N', substr($this->udp->response, 5, strlen($this->udp->response) - 5));
    }

    public function info() {
        $handshake = $this->getChallange();

        $this->udp->send($this->ip, $this->port, "\xFE\xFD\x00\x01\x02\x03\x04$handshake\x00\x00\x00\x00");
        $this->udp->receive($this->ip, $this->port);

        $this->info = (array)new Minecraft\Mapper\INFO($this->udp->response);
    }
}
