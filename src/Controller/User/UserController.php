<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user/", name="user_user")
     */
    public function new(): Response
    {
        return $this->render('user/home/index.html.twig', [
        ]);
    }
}
