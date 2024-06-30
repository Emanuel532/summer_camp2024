<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ExercitiiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ViewExercisesController extends AbstractController
{
    #[Route('/view-exercises', name: 'view_exercises')]
    public function viewExercises(ExercitiiRepository $exercitiiRepository): Response
    {
        $exercises = $exercitiiRepository->findAllExercises();


        return $this->render('view_exercises/view_exercises.html.twig', [
            'exercises' => $exercises,
        ]);
    }
}

