<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\MessageService\CreatedIndexMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SmsNotificationHandler
{
    public function __invoke(CreatedIndexMessage $message)
    {
    }
}
