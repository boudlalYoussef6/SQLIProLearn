<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\UdemyType;
use App\Service\HandlerDataBase;
use App\Service\UdemyApiClient;
use App\Service\UdemyDeserializationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class UdemyController extends AbstractController
{
    #[Route('/udemy/add', name: 'app_add_cours')]
    public function addCourse(Request $request,
                              UdemyApiClient $udemyApiClient,
                              HandlerDataBase $handlerDataBase,
                              UdemyDeserializationService $deserializationService): Response
    {
        $form = $this->createForm(UdemyType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $id = $data['id'];

            $courseData = $udemyApiClient->getCourseById($id);

            $course = $deserializationService->deserializeCourse($courseData);
            $handlerDataBase->storeCourse($course);
            return $this->redirectToRoute('app_home');
        }
        return $this->render('udemy/add_cours.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}







