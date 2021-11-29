<?php

namespace BeyondCode\LaravelWebSockets\WebSockets\Messages;

use BeyondCode\LaravelWebSockets\WebSockets\Channels\ChannelManager;
use Illuminate\Support\Str;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

class PusherMessageFactory
{
    public static function createForMessage(
        MessageInterface $message,
        ConnectionInterface $connection,
        ChannelManager $channelManager): PusherMessage
    {
        $payload = json_decode($message->getPayload());

        if(Str::startsWith($payload->event, 'pusher:')){
            $message = new PusherChannelProtocolMessage($payload, $connection, $channelManager);
        }elseif(Str::startsWith($payload->event, 'host:')){
            $message = new PusherHostMessage($payload, $connection, $channelManager);
        }else{
            $message = new PusherClientMessage($payload, $connection, $channelManager);
        }
        return $message;
    }
}
