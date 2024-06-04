<?php

declare(strict_types=1);

namespace App\Controller;

use App\Indexation\Invoker\DefaultIndexationCommand;
use App\Message\CreatedIndexMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    private DefaultIndexationCommand $indexationCommand;

    public function __construct(DefaultIndexationCommand $indexationCommand)
    {
        $this->indexationCommand = $indexationCommand;
    }

    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        // Create a new message
        $message = new CreatedIndexMessage();
        $message->setCourseReference(123);

        // Execute the indexation command
        $this->indexationCommand->execute($message);

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
