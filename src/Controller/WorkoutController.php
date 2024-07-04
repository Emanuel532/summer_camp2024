<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Form\Type\ExerciseUpdateType;
use App\Form\Type\WorkoutType;
use App\Repository\TipRepository;
use App\Repository\UserRepository;
use App\Repository\WorkoutRepository;
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

    #[Route('/workouts/new', name: 'workouts_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, TipRepository $tipRepository, UserRepository $userRepository): Response
    {
        $workout = new Workout();
        $tipValues = $tipRepository->findAll();
        $users = $userRepository->findAll();

        $form = $this->createForm(WorkoutType::class, $workout, [
            'tipuri' => $tipValues,
            'users' => $users,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tip_selectat = $tipRepository->find($workout['tip']);
            $user_selectat = $userRepository->find($workout['users']);

            $workout->setTipId($tip_selectat);
            $workout->setUser($user_selectat);
            $entityManager->persist($workout);
            $entityManager->flush();

            return $this->redirectToRoute('workouts_show', ['id' => $workout->getId()]);
        }

        return $this->render('workouts/new_workout.html.twig', [
            'form' => $form,
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
