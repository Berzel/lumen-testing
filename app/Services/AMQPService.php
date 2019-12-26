<?php

namespace App\Services;

use App\Events\Event;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPService
{
    public function __construct()
    {
        $host = env('AMQP_HOST');
        $port = env('AMQP_PORT');
        $user = env('AMQP_USER');
        $password = env('AMQP_PASSWORD');
        $vhost = env('AMQP_VHOST');
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password, $vhost);
        $this->channel = $this->connection->channel();
    }

    public function publish(Event $event)
    {
        $this->channel->exchange_declare($event->getName(), 'fanout', false, true, false);

        $message = new AMQPMessage(json_encode($event->getData()), [
            'Content Type' => 'application/json',
            'delivery mode' => 2
        ]);

        $this->channel->basic_publish($message, $event->getName());
    }
}
