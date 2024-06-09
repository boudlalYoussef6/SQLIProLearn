<?php

declare(strict_types=1);

namespace App\Controller;

use App\Author\Factory\DefaultAuthorFactory;
use App\Course\Attachment\AttachmentManagerInterface;
use App\Course\Attachment\DefaultAttachmentManager;
use App\Course\Handler\CourseHandlerInterface;
use App\Course\Persister\Command\Doctrine\AddCourseCommand;
use App\Course\Persister\Command\Doctrine\DeleteCourseCommand;
use App\Course\Persister\Command\Doctrine\UpdateCourseCommand;
use App\Entity\Course;
use App\Form\CourseType;
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
        $form = $this->createForm(CourseType::class, $course);

        return $this->render('course/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/course/add', name: 'app_course_add')]
    public function addCourse(
        Request $request,
        DefaultAuthorFactory $authorFactory,
        AttachmentManagerInterface $attachmentManager,
    ): Response {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userIdentifier = $this->getUser()->getUserIdentifier();
            $authorFactory->affectAuthorToCourse($userIdentifier, $course);

            $course = $attachmentManager->save($course);

            $this->courseHandler->add($course);

            return $this->redirectToRoute('app_cours');
        }

        return $this->render('course/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/cours/{id}', name: 'app_course_details')]
    public function courseDetails(Course $course): Response
    {
        $sections = $course->getSections();
        $author = $course->getAuthor();
        $category = $course->getCategory();
        $videoFileName = $course->getVideoPathName();
        $videoUrl = 'http://localhost:9000/videos/'.$videoFileName;

        return $this->render('course/details.html.twig', [
            'course' => $course,
            'sections' => $sections,
            'author' => $author,
            'category' => $category,
            'video_url' => $videoFileName ? 'http://localhost:9000/videos/'.$videoFileName : null,
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

            return $this->redirectToRoute('app_course_details', ['id' => $course->getId()]);
        }

        return $this->render('course/section-ajout.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }
}
