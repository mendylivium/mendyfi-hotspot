<?php
/**
 * Developed by Rommel A. Mendiola
 */
class SocketServer
{
    private $sockets = [];
    private $onPacket;

    public function log($str)
    {
        echo("$str\r\n");
    }

    public function __construct()
    {
        $this->log('Server Initialized');

        if (PHP_MAJOR_VERSION < 8) {
            die("Minimum PHP version 8 required.");
        }

        if (!function_exists("socket_create")) {
            die("Sockets not available.");
        }
    }

    public function addListener($hostIp, $hostPort)
    {
        $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

        if (!$socket) {
            $this->log("Failed to create socket: " . socket_strerror(socket_last_error()));
            return;
        }

        $this->sockets[] = $socket;

        if (!socket_bind($socket, $hostIp, $hostPort)) {
            $this->log("Failed to bind socket: " . socket_strerror(socket_last_error($socket)));
            return;
        }

        socket_set_nonblock($socket);

        $this->log("Listening on $hostIp:$hostPort");
    }

    public function on($eventName, callable $callback)
    {
        if ($eventName == 'Packet') {
            $this->onPacket = $callback;
        }
    }

    public function run()
    {
        $bufferSize = 65535;
        $packet = '';

        while (true) {
            $read = $this->sockets;
            $write = null;
            $except = null;

            $numChangedSockets = socket_select($read, $write, $except, 0, 500000); // Timeout: 0.5 seconds

            if ($numChangedSockets === false) {
                $this->log('socket_select error: ' . socket_strerror(socket_last_error()));
                continue;
            }

            foreach ($read as $socket) {
                $result = socket_recvfrom($socket, $packet, $bufferSize, 0, $remoteIp, $remotePort);

                if ($result === false) {
                    $this->log("socket_recvfrom error: " . socket_strerror(socket_last_error($socket)));
                    continue;
                }

                if (strlen($packet) < 4) {
                    continue;
                }

                if (is_callable($this->onPacket)) {
                    call_user_func($this->onPacket, $this, $packet, [ 'address' => $remoteIp, 'port' => $remotePort, 'server_socket' => $socket ]);
                }
            }
        }
    }

    public function sendto($destinationIp, $destinationPort, $packets, $socket)
    {
        $result = socket_sendto($socket, $packets, strlen($packets), 0, $destinationIp, $destinationPort);
        if ($result === false) {
            $this->log("socket_sendto error: " . socket_strerror(socket_last_error($socket)));
            return false;
        }
        return true;
    }

    public function close()
    {
        foreach ($this->sockets as $socket) {
            socket_close($socket);
        }
    }

    public function __destruct()
    {
        $this->close();
    }
}