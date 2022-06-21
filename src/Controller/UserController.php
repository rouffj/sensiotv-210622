<?php

namespace App\Controller;

use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $userForm = $this->createForm(UserType::class);

        $userForm->handleRequest($request);
        
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user = $userForm->getData();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->renderForm('user/register.html', [
            'user_form' => $userForm
        ]);
    }

    #[Route('/login', name: 'signin')]
    public function signin(): Response
    {
        return $this->render('user/signin.html', [
            'controller_name' => 'UserController',
        ]);
    }
}
