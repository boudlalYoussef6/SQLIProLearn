<?php

namespace App\Controller;

use App\Service\UdemyApiClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UdemyController extends AbstractController
{
    #[Route('/udemy', name: 'app_udemy')]
    public function index(UdemyApiClient $udemyApiClient): Response
    {
        $courses = $udemyApiClient->getCourses();

        return $this->render('udemy/index.html.twig', [
            'courses' => $courses['results'],
        ]);
    }

}
