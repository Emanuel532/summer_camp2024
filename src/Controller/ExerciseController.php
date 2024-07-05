<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Exercitii;
use App\Form\Type\ExerciseType;
use App\Form\Type\ExerciseUpdateType;
use App\Repository\ExercitiiRepository;
use App\Repository\TipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciseController extends AbstractController
{
    #[Route('/exercises', name: 'view_exercises', methods: ['GET'])]
    public function viewExercises(ExercitiiRepository $exercitiiRepository): Response
    {
        $exercises = $exercitiiRepository->findAllExercises();


        return $this->render('exercises/view_exercises.html.twig', [
            'exercises' => $exercises,
        ]);
    }

    #[Route('/exercises/{id}', name: 'view_exercise', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function viewExercise($id, ExercitiiRepository $exercitiiRepository): Response
    {
        $exercise = $exercitiiRepository->find($id);
        if (!$exercise) {
            throw $this->createNotFoundException();
        } else {
            return $this->render('exercises/exercise.html.twig', ['id' => $id, 'exercise' => $exercise]);
        }
    }

    #[Route('/exercises/{id}', name: 'delete_exercise', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteExercise($id, ExercitiiRepository $exercitiiRepository): Response
    {
        $deletedRows = $exercitiiRepository->deleteExercise($id);
        $status = $deletedRows > 0 ? 'success' : 'failure';

       // return $this->render('exercises/delete_exercise.html.twig', ["exercise_id" => $id, 'status' => $status]);
        return new JsonResponse(['status' => 'success', 'exercise_id' => $id]);
    }

    #[Route('/exercises/new', name: 'new_exercise', methods: array('GET'))]
    public function newPage(Request $request, EntityManagerInterface $entityManager, TipRepository $tipRepository): Response
    {
        $exercise = new Exercitii();

        $tip_values = $tipRepository->findAll();

        $form = $this->createForm(ExerciseType::class, $exercise, [
            'data' => $tip_values,
            'action' => $this->generateUrl('create_new_exercise'),
        ]);


        return $this->render('exercises/addExercisePage.html.twig', ['form' => $form]);
    }

    #[Route('/exercises', name: 'create_new_exercise', methods: array('POST'))]
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

            $newCreatedId = $exercitiu->getId();

            return $this->redirectToRoute('view_exercise', ['id' => $newCreatedId]);

        }


        return $this->redirect('/exercises');
    }

    #[Route('/deleted_exercise', name: 'deleted_exercise_status', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteExerciseStatus(Request $request): Response
    {
        $exerciseId = $request->query->get('exercise_id');
        $status = $request->query->get('status');

        return $this->render('exercises/delete_exercise.html.twig', [
            'exercise_id' => $exerciseId,
            'status' => $status
        ]);
    }

    //edit:

    #[Route('/exercises/{id}/edit', name: 'edit_exercise', methods: ['GET'])]
    public function edit(Exercitii $exercise, Request $request, EntityManagerInterface $entityManager,TipRepository $tipRepository): Response
    {
        $tipValues = $tipRepository->findAll();

        $form = $this->createForm(ExerciseUpdateType::class, $exercise
            , [
                'tipuri' => $tipValues,

            ]);



        return $this->render('exercises/updateExercisePage.html.twig', ['form' => $form, 'exercise' => $exercise]);
    }

    #[Route('/exercises/{id}', name: 'update_exercise', methods: ['PATCH', 'PUT'])]
    public function updateExercise(Exercitii $exercise, Request $request, EntityManagerInterface $entityManager, TipRepository $tipRepository, ExercitiiRepository $exercitiiRepository): Response
    {
        $exercise_id = $exercise->getId();

        $tipValues = $tipRepository->findAll();

        $form = $this->createForm(ExerciseUpdateType::class, $exercise, [
            'tipuri' => $tipValues,
        ]);

        $arrayValori = [];
        foreach($request->getPayload() as $key => $value) {
            $arrayValori[$key] = $value;
        }
        $exerciseUpdate = $arrayValori['exercise_update'];


        if($exerciseUpdate['nume']!= null and $exerciseUpdate['link_video'] != null) { //request validation
            $exercise = $exercitiiRepository->find($exercise_id);

            $exercise->setNume($exerciseUpdate['nume']);
            $exercise->setLinkVideo($exerciseUpdate['link_video']);

            $tipToBeAdded = $tipRepository->find($exerciseUpdate['tip']);
            $exercise->setTipId($tipToBeAdded);
            $entityManager->persist($exercise);
            $entityManager->flush();

            return $this->render('exercises/updateExercisePage.html.twig', [
                'form' => $form->createView(),
                'exercise' => $exercise,
            ]);
        }
        return new Response();
    }

}
