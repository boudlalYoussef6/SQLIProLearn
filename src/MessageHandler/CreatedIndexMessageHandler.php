<?php

namespace App\MessageHandler;

use App\MessageService\CreatedIndexMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreatedIndexMessageHandler
{
    public function __invoke(CreatedIndexMessage $message)
    {

        $courseReference = $message->getCourseReference();

    }
}
