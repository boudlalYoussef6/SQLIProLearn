<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CoursType;
use App\Repository\CourseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoursController extends AbstractController
{
    #[Route('/cours', name: 'app_cours')]
    public function index(CourseRepository $courseRepository, Request $request): Response
    {
        $courses = $courseRepository->findAll();

        $course = new Course();
        $form = $this->createForm(CoursType::class, $course);

        return $this->render('cours/index.html.twig', [
            'courses' => $courses,
            'form' => $form
        ]);
    }

    #[Route('/cours/add', name: 'app_cours_add')]
    public function CoursAdd(Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CoursType::class, $course);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('cours/ajout.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/cours/{id}', name: 'app_cours_details')]
    public function coursDetails(CourseRepository $courseRepository, $id, Request $request): Response
    {
        $course = $courseRepository->findBy($id);

        return $this->render('cours/index.html.twig', [
            'course' => $course,
        ]);
    }
}
