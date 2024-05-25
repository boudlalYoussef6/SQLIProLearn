<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApplicationController extends AbstractController
{
    #[Route('/application', name: 'app_application')]
    public function index(): Response
    {
        return $this->render('application/index.html.twig', [
            'controller_name' => 'ApplicationController',
        ]);
    }

    #[Route('/addApplication', name: 'app_application_add')]
    public function addApplication(): Response
    {
        return $this->render('application/add_application.html.twig', [
            'controller_name' => 'ApplicationController',
        ]);
    }
}
