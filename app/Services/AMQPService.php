<?php

namespace App\Services;

use App\Events\Event;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AMQPService
{
    /**
     * The default channel this application will use to publish messages
     * 
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private AMQPChannel $channel;

    /**
     * The AMQP connection
     * 
     * @var \PhpAmqpLib\Connection\AMQPStreamConnection
     */
    private AMQPStreamConnection $connection;

    /**
     * Create a new AMQP Service instance
     * 
     * @return void
     */
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

    /**
     * Publish an event to it's exchange
     * 
     * @param App\Events\Event $event
     * @return void
     */
    public function publish(Event $event)
    {
        $this->channel->exchange_declare($event->getName(), AMQPExchangeType::FANOUT, false, true, false);

        $message = new AMQPMessage(json_encode($event->getData()), [
            'content_type' => 'application/json',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $this->channel->basic_publish($message, $event->getName());
    }
}
