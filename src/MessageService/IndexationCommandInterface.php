<?php

declare(strict_types=1);

namespace App\MessageService;

interface IndexationCommandInterface
{
    public function execute(IndexationMessageInterface $message): void;
}
