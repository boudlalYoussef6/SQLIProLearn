<?php

declare(strict_types=1);

namespace App\Indexation\Invoker;

use App\Message\IndexationMessageInterface;

interface IndexationCommandInterface
{
    public function execute(IndexationMessageInterface $message): void;
}
