<?php 
namespace App\Consumer;
use Doctrine\ORM\EntityManagerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class MessageConsumer
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function execute(AMQPMessage $msg)
    {
        $data = json_decode($msg->body, true);

    }
}
