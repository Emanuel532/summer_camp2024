<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ExercitiiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteExerciseController extends AbstractController
{
    #[Route('/delete-exercise/{id}', name: 'delete_exercise')]
    public function index($id, ExercitiiRepository $exercitiiRepository): Response
    {
        $deletedRows = $exercitiiRepository->deleteExercise($id);
        $status = $deletedRows > 0 ? 'success' : 'failure';

        return $this->render('delete_exercise.html.twig', ["exercise_id" => $id,'status' => $status]);
    }
}
