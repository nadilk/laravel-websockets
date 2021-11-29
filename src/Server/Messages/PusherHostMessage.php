<?php

namespace BeyondCode\LaravelWebSockets\Server\Messages;

use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManager;
use Ratchet\ConnectionInterface;
use stdClass;

class PusherHostMessage implements PusherMessage
{
    /** \stdClass */
    protected $payload;

    /** @var \Ratchet\ConnectionInterface */
    protected $connection;

    /** @var \BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManager */
    protected $channelManager;

    public function __construct(stdClass $payload, ConnectionInterface $connection, ChannelManager $channelManager)
    {
        $this->payload = $payload;

        $this->connection = $connection;

        $this->channelManager = $channelManager;
    }

    public function respond()
    {
        $channel = $this->channelManager->find($this->connection->app->id, $this->payload->channel);

        if($channel instanceof IHandlesClientMessage){
            if($channel->validateClientEvent($this->payload)){
                $channel->handleEventFromClient($this->payload);
            }
        }else{
            optional($channel)->broadcastToOthers($this->connection, $this->payload);
        }

    }
}

