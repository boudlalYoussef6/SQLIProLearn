<?php

declare(strict_types=1);

namespace App\Controller;

use App\Course\Fetcher\CourseFetcherInterface;
use App\Course\Handler\CourseHandlerInterface;
use App\Factory\Course\UdemyCourseFactory;
use App\Form\UdemyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UdemyController extends AbstractController
{
    public function __construct(
        private readonly CourseFetcherInterface $fetcher,
        private readonly UdemyCourseFactory $factory,
    ) {
    }

    #[Route('/udemy/add', name: 'app_add_course_from_udemy')]
    public function addCourse(Request $request, CourseHandlerInterface $handler): Response
    {
        $form = $this->createForm(UdemyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $id = $data['id'];
            $category = $data['category'];

            $content = $this->fetcher->fetch($id);

            $this->factory->addCourse($content, $category, $handler);

            $this->addFlash('success', 'Le nouveau cours sera publié prochainement.');

            return $this->redirectToRoute('app_course');
        }

        return $this->render('udemy/add_cours.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
