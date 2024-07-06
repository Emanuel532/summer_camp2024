<?php

namespace App\Controller;

use App\Entity\ExerciseLog;
use App\Entity\Workout;
use App\Form\Type\ExerciseUpdateType;
use App\Form\Type\WorkoutType;
use App\Repository\ExercitiiRepository;
use App\Repository\TipRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{
    #[Route('/workouts', name: 'workouts_index', methods: ['GET'])]
    public function index(WorkoutRepository $workoutRepository): Response
    {
        $workouts = $workoutRepository->findAll();


        return $this->render('workouts/view_workouts.html.twig', [
            'workouts' => $workouts,
        ]);
    }

    #[Route('/workouts/new', name: 'workouts_new')]
    public function new(Request $request, UserRepository $userRepository, TipRepository $tipRepository,ExercitiiRepository $exercitiiRepository, EntityManagerInterface $entityManager): Response
    {
        $arrayValori = [];
        foreach ($request->getPayload() as $key => $value) {
            $arrayValori[$key] = $value;
        }

        $workout_id_to_redirect = -1;
        if($arrayValori != [])
        if ($arrayValori['nume'] != null and $arrayValori['user'] != null) { //request validation
            //to create a new workoutf

            $workout = new Workout();
            $workout->setNume($arrayValori['nume']);

            $user = $userRepository->find($arrayValori['user']);
            $workout->setUser($user);


            $date = DateTime::createFromFormat('Y-m-d', $arrayValori['date']);
            $workout->setDate($date);

            $tip = $tipRepository->find(3);

            $workout->setTipId($tip);
            $entityManager->persist($workout);
            $entityManager->flush();


            for($i = 0; $i < count($arrayValori['exercise_id']); $i++) {
                $exerciseLog = new ExerciseLog();

                $exercitiu = $exercitiiRepository->find($arrayValori['exercise_id'][$i]);
                $exerciseLog->setExercise($exercitiu);

                $exerciseLog->setWorkout($workout);
                $exerciseLog->setNrReps($arrayValori['nr_reps'][$i]);


                $exerciseLog->setDuration($arrayValori['duration'][$i]);
                $entityManager->persist($exerciseLog);
                $entityManager->flush();
            }
            return $this->redirectToRoute('workouts_show', ['id' => $workout->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('workouts/new.html.twig', ['exercitiiList' => $exercitiiRepository->findAll(),
            'userList' => $userRepository->findAll(),
            ]);
    }

    #[Route('/workouts/{id}', name: 'workouts_show', methods: ['GET'])]
    public function show(Workout $workout): Response
    {
        return $this->render('workouts/workout.html.twig', [
            'workout' => $workout,
        ]);
    }

    #[Route('/workouts/{id}/edit', name: 'workouts_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Workout $workout, EntityManagerInterface $entityManager, TipRepository $tipRepository, UserRepository $userRepository): Response
    {
        $tipValues = $tipRepository->findAll();
        $users = $userRepository->findAll();

        $form = $this->createForm(WorkoutType::class, $workout
            , [
                'tipuri' => $tipValues,
                'users' => $users,
            ]);



        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('workouts_show', ['id' => $workout->getId()]);
        }

        return $this->render('workouts/edit_workouts.html.twig', [
            'workout' => $workout,
            'form' => $form,
        ]);
    }

    #[Route('/workouts/{id}', name: 'workouts_delete', methods: ['DELETE'])]
    public function delete(Request $request, Workout $workout, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workout->getId(), $request->request->get('_token'))) {
            $entityManager->remove($workout);
            $entityManager->flush();
        }

        return $this->redirectToRoute('workouts_index');
    }
}
