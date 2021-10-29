<?php

namespace App\Controller\Annonceur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnnonceurController extends AbstractController
{
    /**
     * @Route("/annonceur", name="anonceur_annonceur")
     */
    public function index(): Response
    {
        return $this->render('annonceur/index.html.twig', [
            'controller_name' => 'AnnonceurController',
        ]);
    }
}
