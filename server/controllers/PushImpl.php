<?php
/* use Ratchet\Server\IoServer; */
/* use Ratchet\Http\HttpServer; */
/* use Ratchet\WebSocket\WsServer; */
/* use Ratchet\Wamp\WampServer; */
/* require_once 'models/Pusher.php'; */
require_once 'models/WebsocketClient.php';

class PushImpl 
{

    public function push() {
        $WebSocketClient = new WebsocketClient('localhost', 8000);
        echo $WebSocketClient->sendData('good boy');
        unset($WebSocketClient);
    }

    /* private $loop; */
    /* private $pusher; */

    /* public function __construct() { */
    /*     $this->loop = React\EventLoop\Factory::create(); */
    /*     $this->pusher = new Pusher; */
    /* } */

    /* public function push() { */
    /*     // Listen for the web server to make a ZeroMQ push after an push request */
    /*     $context = new React\ZMQ\Context($this->loop); */
    /*     $pull = $context->getSocket(ZMQ::SOCKET_PULL); */
    /*     $pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself */
    /*     $pull->on('message', array($this->pusher, 'onBlogEntry')); */

    /*     // Set up our WebSocket server for clients wanting real-time updates */
    /*     $webSock = new React\Socket\Server($this->loop); */
    /*     $webSock->listen(9090, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect */
    /*     $webServer = new IoServer(new HttpServer(new WsServer(new WampServer($this->pusher))), $webSock); */ 

    /*     /1* $this->loop->run(); *1/ */
    /*     /1* $server = IoServer::factory(new HttpServer(new WsServer(new Push())), 8000); *1/ */
    /*     /1* $server->run(); *1/ */
    /* } */

}
