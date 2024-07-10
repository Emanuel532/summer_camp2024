<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\BMILog;
use App\Form\Type\BMIType;
use App\Repository\BMILogRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BMIController extends AbstractController
{
    #[Route('/bmi', name: 'bmi')]
    public function index(Request $request, EntityManagerInterface $entityManager, BMILogRepository $bmiLogRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($this->getUser()->getUserId());
        $form = $this->createForm(BMIType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $bmiLog = new BMILog();
            $bmiLog->setUser($user);
            $bmiLog->setWeight( intval($data['weight']) );

            $bmiLog->setHeight( intval($data['height']));
            $bmiLog->setCreatedAt(new \DateTime());

            $entityManager->persist($bmiLog);
            $entityManager->flush();

            header("Refresh:0");
        }
        $bmiLogs = $bmiLogRepository->findBy(['user' => $user->getId()]);

        return $this->render('bmi/index.html.twig', [
            'form' => $form->createView(),
            'bmiLogs' => $bmiLogs,
        ]);
    }
}
