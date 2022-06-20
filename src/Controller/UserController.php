<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/register', name: 'register')]
    public function register(): Response
    {
        return $this->render('user/register.html', [
            'controller_name' => 'UserController',
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
