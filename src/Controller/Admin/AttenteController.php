<?php

namespace App\Controller\Admin;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttenteController extends AbstractController
{
    /**
     * @Route("/admin/attente", name="admin_attente_index")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('admin/attente/index.html.twig', [
            'annonces' => $annonceRepository->etat('En attente'),
        ]);
    }
}
