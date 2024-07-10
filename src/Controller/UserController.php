<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Form\Type\UserUpdateType;
use App\Repository\ExercitiiRepository;
use App\Repository\UserAccountRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/your-profile', name: 'your-profile', methods: ['GET'])]
    public function viewYourAccount(UserRepository $userRepository): Response
    {
        //get your current connected user
        if ($this->getUser() != null) {
            $user = $userRepository->findBy(['userAccount' => $this->getUser()->getId()])[0];

            return $this->redirectToRoute('view_user', ['id' => $user->getId()]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/users', name: 'users', methods: ['GET'])]
    public function viewAllUsers(UserRepository $userRepository, EntityManagerInterface $entityManager): Response {

        if($this->getUser() != null) {
            $hasAccess = $this->isGranted('ROLE_ADMIN');
            if($hasAccess) {
                $users = $userRepository->findAll();
                return $this->render('users/view_users.html.twig', ['users' => $users]);
            } else {
                return $this->redirectToRoute('view_user', ['id' => $this->getUser()->getUserId()->getId()]);
            }

        }
        return $this->redirectToRoute('app_login');

    }

    #[Route('/users/{id}', name: 'view_user', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function view(User $user): Response
    {
        return $this->render('users/view.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/users/new', name: 'create_new_user', methods: ['GET', "POST"])]
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
            return $this->redirectToRoute('view_user', ['id' => $user->getId()]);
        }


        return $this->render('users/addUserPage.html.twig', ['form' => $form]);
    }

    #[Route('/users/{id}', name: 'delete_user', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function deleteUser($id, UserRepository $userRepository, UserAccountRepository $userAccountRepository): Response
    {
        $user = $userRepository->find($id);
        $account_id = $user->getUserAccount()->getId();

        $userRepository->deleteUser($user->getId());

        $userAccountRepository->deleteUser($account_id);

        $deletedRows = $userRepository->deleteUser($id);

        $status = $deletedRows > 0 ? 'success' : 'failure';

        return new JsonResponse(['status' => $status, 'user_id' => $id]);
    }

    #[Route('/delete_user', name: 'delete_user_status', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function deleteExerciseStatus(Request $request): Response
    {
        $userId = $request->query->get('user_id');
        $status = $request->query->get('status');

        return $this->render('users/delete_user.html.twig', [
            'user_id' => $userId,
            'status' => $status
        ]);
    }

    #[Route('/users/{id}/update', name: 'update_user', methods: ['GET', "POST"])]
    public function update(User $user, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {

        $form = $this->createForm(UserUpdateType::class, $user);



        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('view_user', ['id' => $user->getId()]);
        }


        return $this->render('users/updateUserPage.html.twig', ['form' => $form]);
    }

}
