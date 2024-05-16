<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CoursType;
use App\Form\DetailsCourseType;
use App\Form\SectionType;
use App\Repository\CourseRepository;
use App\Repository\SectionRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function CoursAdd(Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = new Course();
        $form = $this->createForm(CoursType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($course);
            $entityManager->flush();
            return $this->redirectToRoute('app_cours');
        }

        return $this->render('cours/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/cours/{id}', name: 'app_cours_details')]
    public function courseDetails(CourseRepository $courseRepository, $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = $courseRepository->findOneBy(['id' => $id]);
        $sections = $course->getSections();

        return $this->render('cours/details.html.twig', [
            'course' => $course,
            'sections' => $sections,
        ]);
    }

    #[Route('/cours/ajout/{id}', name: 'app_cours_ajout_section')]
    public function courseAjoutSection(CourseRepository $courseRepository, $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = $courseRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(DetailsCourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_details', ['id' => $id]);
        }

        return $this->render('cours/section-ajout.html.twig', [
            'course' => $course,
            'form' => $form
        ]);
    }
}
