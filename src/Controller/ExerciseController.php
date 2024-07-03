<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Exercitii;
use App\Form\Type\ExerciseType;
use App\Repository\ExercitiiRepository;
use App\Repository\TipRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseController extends AbstractController
{


    #[Route('/exercises/delete/{id}', name: 'delete_exercise')]
    public function deleteExercise($id, ExercitiiRepository $exercitiiRepository): Response
    {
        $deletedRows = $exercitiiRepository->deleteExercise($id);
        $status = $deletedRows > 0 ? 'success' : 'failure';

        return $this->render('exercises/delete_exercise.html.twig', ["exercise_id" => $id, 'status' => $status]);
    }

    #[Route('/exercises', name: 'view_exercises')]
    public function viewExercises(ExercitiiRepository $exercitiiRepository): Response
    {
        $exercises = $exercitiiRepository->findAllExercises();


        return $this->render('exercises/view_exercises.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/exercises/new', methods: array('GET', 'POST'))]
    public function new(Request $request, EntityManagerInterface $entityManager, TipRepository $tipRepository): Response
    {
        $exercise = new Exercitii();

        $tip_values = $tipRepository->findAll();

        $form = $this->createForm(ExerciseType::class, $exercise, [
            'data' => $tip_values,
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $exercise = $form->getData();

            $exercitiu = new Exercitii();

            $tip_de_adaugat = $tipRepository->find($exercise["tip"]);

            $exercitiu->setNume($exercise["nume"]);
            $exercitiu->setLinkVideo($exercise["link_video"]);
            $exercitiu->setTipId($tip_de_adaugat);

            $entityManager->persist($exercitiu);
            $entityManager->flush();
        }


        return $this->render('exercises/addExercisePage.html.twig', ['form' => $form]);
    }
}
