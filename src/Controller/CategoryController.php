<?php

declare(strict_types=1);

namespace App\Controller;

use App\Category\CategoryExposerInterface;
use FOS\ElasticaBundle\Index\IndexManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    public function __construct(private readonly IndexManager $manager)
    {
    }

    public function menu(CategoryExposerInterface $exposer, ?int $selectedMenu = null): Response
    {
        $menu = $exposer->expose();

        return $this->render('category/index.html.twig', [
            'items' => $menu,
            'selected' => $selectedMenu,
        ]);
    }
}
