<?php

namespace App\Controller;
use App\Message\SmsNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageController extends AbstractController
{
    #[Route('/message', name: 'app_message')]
    public function index(MessageBusInterface $bus): Response
    {
        try { $bus->dispatch(new SmsNotification('Look! I created a message!'));
        } catch(\Exception $e) {

            dd($e);
        }
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
}
