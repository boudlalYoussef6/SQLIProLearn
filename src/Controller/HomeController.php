<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(private readonly LoggerInterface $logger){
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $this->logger->info('MESSAGE_FROM_SYMFONY', ['username' => 'user Clone', 'who_is' => 'e-challenger']);

        return $this->render('home/index.html.twig');
    }
}
