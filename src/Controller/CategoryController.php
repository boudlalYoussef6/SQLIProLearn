<?php

declare(strict_types=1);

namespace App\Controller;

use App\Category\CategoryExposerInterface;
use FOS\ElasticaBundle\Index\IndexManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    public function __construct(private readonly IndexManager $manager)
    {
    }

    public function menu(CategoryExposerInterface $exposer): Response
    {
        $menu = $exposer->expose();

        return $this->render('category/index.html.twig', [
            'items' => $menu,
        ]);
    }
}
