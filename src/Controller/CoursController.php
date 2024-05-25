<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Course;
use App\Form\CoursType;
use App\Form\DetailsCourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CoursController extends AbstractController
{
    #[Route('/', name: 'app_cours')]
    public function index(CourseRepository $courseRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $courseRepository->createQueryBuilder('c');

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            6
        );

        $course = new Course();
        $form = $this->createForm(CoursType::class, $course);

        return $this->render('cours/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
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
            'form' => $form,
        ]);
    }
}
