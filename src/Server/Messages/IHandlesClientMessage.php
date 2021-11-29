<?php

namespace BeyondCode\LaravelWebSockets\Server\Messages;

interface IHandlesClientMessage
{
    public function validateClientEvent($event);

    public function handleEventFromClient($event);
}
