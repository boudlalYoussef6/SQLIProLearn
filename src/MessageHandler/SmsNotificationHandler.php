<?php 

namespace App\MessageHandler;

use App\Message\SmsNotification;
use App\MessageService\CreatedIndexMessage;
use App\MessageService\RevokeIndexMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SmsNotificationHandler
{

    public function __invoke(CreatedIndexMessage $message)
    {
    }


}