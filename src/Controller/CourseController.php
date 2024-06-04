<?php

declare(strict_types=1);

namespace App\Controller;

use App\Author\Factory\DefaultAuthorFactory;
use App\Course\Handler\CourseHandlerInterface;
use App\Course\Persister\Command\Doctrine\AddCourseCommand;
use App\Course\Persister\Command\Doctrine\DeleteCourseCommand;
use App\Course\Persister\Command\Doctrine\UpdateCourseCommand;
use App\Entity\Course;
use App\File\Uploader\FileProcessor;
use App\Form\CoursType;
use App\Form\DetailsCourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseController extends AbstractController
{
    public function __construct(
        private readonly AddCourseCommand $addCourseCommand,
        private readonly DeleteCourseCommand $deleteCourseCommand,
        private readonly UpdateCourseCommand $updateCourseCommand,
        private readonly CourseHandlerInterface $courseHandler,
    ) {
    }

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

    #[Route('/course/add', name: 'app_cours_add')]
    public function addCourse(
        Request $request,
        FileProcessor $processor,
        DefaultAuthorFactory $authorFactory,
    ): Response {
        $course = new Course();
        $form = $this->createForm(CoursType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $processor->process($course, $form->get('videoPath')->getData());

            $userIdentifier = $this->getUser()->getUserIdentifier();
            $authorFactory->affectAuthorToCourse($userIdentifier, $course);

            $this->courseHandler->add($course);

            return $this->redirectToRoute('app_cours');
        }

        return $this->render('cours/ajout.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cours/{id}', name: 'app_cours_details')]
    public function coursDetails(CourseRepository $courseRepository, Course $course): Response
    {
        $sections = $course->getSections();
        $author = $course->getAuthor();
        $category = $course->getCategory();
        $videoFileName = $course->getVideoPathName();
        $videoUrl = 'http://localhost:9000/videos/'.$videoFileName;

        return $this->render('cours/details.html.twig', [
            'course' => $course,
            'sections' => $sections,
            'author' => $author,
            'category' => $category,
            'video_url' => $videoUrl,
        ]);
    }

    #[Route('/cours/ajout/{id}', name: 'app_cours_ajout_section')]
    public function courseAjoutSection(
        Course $course,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(DetailsCourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_details', ['id' => $course->getId()]);
        }

        return $this->render('cours/section-ajout.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }
}
