<?php

declare(strict_types=1);

namespace App\Controller;

use App\Author\Factory\DefaultAuthorFactory;
use App\Course\Attachment\AttachmentManagerInterface;
use App\Course\Catalog\CatalogManagerInterface;
use App\Course\Handler\CourseHandlerInterface;
use App\Course\Persister\CoursePersisterInterface;
use App\Course\Query\ItemQueryInterface;
use App\Entity\Course;
use App\Event\NewCourseEvent;
use App\Form\CourseType;
use App\Form\DetailsCourseType;
use App\Repository\FavoryRepository;
use App\Security\Voters\CourseVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CourseController extends AbstractController
{
    public function __construct(
        private readonly CourseHandlerInterface $courseHandler,
        private readonly CoursePersisterInterface $coursePersister,
    ) {
    }

    #[Route('/course', name: 'app_course')]
    public function index(
        Request $request,
        FavoryRepository $favoryRepository,
        CatalogManagerInterface $manager,
    ): Response {
        $userIdentifier = $this->getUser()->getUserIdentifier();

        $favoriteCourses = $favoryRepository->findFavoriteCourses($userIdentifier);

        $paginableCourses = $manager->populate($currentPage = $request->query->getInt('page', 1));

        return $this->render('course/index.html.twig', [
            'favoriteCourses' => $favoriteCourses,
            'courses' => $paginableCourses,
            'currentPage' => $currentPage,
        ]);
    }

    #[Route('/course/add', name: 'app_course_add', priority: 1)]
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

            $this->addFlash('success', 'Le nouveau cours sera publié prochainement.');

            return $this->redirectToRoute('app_course');
        }

        return $this->render('course/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/course/{id}', name: 'app_course_details')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function courseDetails(
        /* Course $course */ int $id,
        ItemQueryInterface $query,
        EventDispatcherInterface $dispatcher,
        Security $security,
        FavoryRepository $favoryRepository,
    ): Response {
        $course = $query->findItem((string) $id);

        if (null === $course) {
            throw $this->createNotFoundException();
        }

        $user = $security->getUser()->getUserIdentifier();

        $userIdentifier = $this->getUser()->getUserIdentifier();

        $dispatcher->dispatch(new NewCourseEvent($id, $userIdentifier));

        $isFavorite = $favoryRepository->isFavorite($user, $course['id']);

        return $this->render('course/details.html.twig', [
            'course' => $course,
            'isFavorite' => $isFavorite,
        ]);
    }

    #[Route('/course/add/{id}', name: 'app_course_add_section')]
    public function courseAddSection(
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

    #[Route('/course/edit/{id}', name: 'app_course_edit')]
    #[IsGranted(CourseVoter::EDIT, 'course')]
    public function editCourse(
        Course $course,
        Request $request,
        ItemQueryInterface $query,
        DefaultAuthorFactory $authorFactory,
        AttachmentManagerInterface $attachmentManager
    ): Response {
        $oldCourse = $query->findItem((string) $course->getId());

        // foreach ($course->getMedias() as $media) {
        //     $course->removeMedia($media);
        // }

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userIdentifier = $this->getUser()->getUserIdentifier();
            $authorFactory->affectAuthorToCourse($userIdentifier, $course);

            $attachmentManager->save($course);

            $this->courseHandler->edit($course);

            $this->addFlash('success', 'Le cours a été mis à jour avec succès. Les modifications seront affichées bientôt.');

            return $this->redirectToRoute('app_course_edit', ['id' => $course->getId()]);
        }

        return $this->render('course/edit.html.twig', [
            'oldCourse' => $oldCourse,
            'course' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/course/delete/{id}', name: 'app_course_delete')]
    #[IsGranted(CourseVoter::DELETE, 'course')]
    public function deleteCourse(Course $course): Response
    {
        $this->courseHandler->delete($course);

        return $this->redirectToRoute('app_course');
    }
}
