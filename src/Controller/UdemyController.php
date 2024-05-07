<?php

namespace App\Controller;

use App\Entity\SerializedCourse;
use App\Service\UdemyApiClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UdemyController extends AbstractController
{
    #[Route('/udemy', name: 'app_udemy')]
    public function index(UdemyApiClient $udemyApiClient): Response
    {
        $courses = $udemyApiClient->getCourses();

        return $this->render('udemy/index.html.twig', [
            'courses' => $courses['results'],
        ]);
    }
    #[Route('/udemy/add', name: 'app_add_cours')]
    public function addCours(Request $request,HttpClientInterface $httpClient,SerializerInterface $serializer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UdemyType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();


            $id = $data['id'];


            $response = $httpClient->request('GET', 'https://www.udemy.com/api-2.0/courses/'.$id);
            $courseData = $response->toArray();
            $serializedCourseData = $serializer->serialize($courseData, 'json');


            $serializedCourse = new SerializedCourse();
            $serializedCourse->setSerializedData($serializedCourseData);


            $entityManager->persist($serializedCourse);
            $entityManager->flush();



            return $this->redirectToRoute('app_home');
        }

        return $this->render('udemy/add_cours.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}
