<?php

declare(strict_types=1);

namespace App\Controller;

use App\Course\Attachment\Command\AttachmentCommandInterface;
use App\Course\Attachment\Command\AttachmentCommandInvokerInterface;
use App\Entity\Course;
use App\Entity\Media;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class AttachmentController extends AbstractController
{
    public function __construct(private readonly AttachmentCommandInterface $removeCommand)
    {
    }

    #[Route('/attachment/delete/{courseId}/{mediaId}', name: 'app_delete_attachment')]
    public function index(
        #[MapEntity(mapping: ['courseId' => 'id'])] Course $course,
        #[MapEntity(mapping: ['mediaId' => 'id'])] Media $media,
        Request $request,
        AttachmentCommandInvokerInterface $invoker,
    ): Response {
        $csrfToken = $request->query->get('_delete_token', '');

        if (!$this->isCsrfTokenValid('__delete_media', $csrfToken)) {
            throw new InvalidCsrfTokenException();
        }

        $invoker->invoke($course, $media, $this->removeCommand);

        return $this->redirectToRoute('app_course_edit', ['id' => $course->getId()]);
    }
}
