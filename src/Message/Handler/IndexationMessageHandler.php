<?php

declare(strict_types=1);

namespace App\Message\Handler;

use App\Message\CreatedIndexMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class IndexationMessageHandler
{
    #[AsMessageHandler]
    public function createNewIndexForCourse(CreatedIndexMessage $message): void
    {
    }
}
