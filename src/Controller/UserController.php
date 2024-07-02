<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Repository\ExercitiiRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    #[Route('/users', name: 'users', methods: ['GET'])]
    public function viewAllUsers(UserRepository $userRepository): Response {

        $users = $userRepository->findAll();

        return $this->render('users/view_users.html.twig', ['users' => $users]);
    }

    #[Route('/users/new', name: 'new_user', methods: ['GET', "POST"])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user, [
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
        }


        return $this->render('users/addUserPage.html.twig', ['form' => $form]);
    }

    #[Route('/users/delete/{id}', name: 'delete_user')]
    public function deleteUser($id, UserRepository $userRepository): Response
    {
        $deletedRows = $userRepository->deleteUser($id);
        $status = $deletedRows > 0 ? 'success' : 'failure';

        return $this->render('users/delete_exercise.html.twig', ["user_id" => $id, 'status' => $status]);
    }
}
