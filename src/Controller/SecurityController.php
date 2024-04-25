<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/security', name: 'app_security_login')]
    public function index(AuthenticationUtils $securityUtils): Response
    {
        $lastError=$securityUtils->getLastAuthenticationError();
        $username=$securityUtils->getLastUsername();

        return $this->render('security/index.html.twig', [
            'last_error' => $lastError,
            'username' => $username,
        ]);
    }
}
