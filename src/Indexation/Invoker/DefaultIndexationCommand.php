<?php

declare(strict_types=1);

namespace App\Indexation\Invoker;

use App\Message\IndexationMessageInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class DefaultIndexationCommand implements IndexationCommandInterface
{
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * Execute the indexation command.
     */
    public function execute(IndexationMessageInterface $message): void
    {
        $this->messageBus->dispatch($message);
    }
}
