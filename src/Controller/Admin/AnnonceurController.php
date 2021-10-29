<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AnnonceurController extends AbstractController
{
    private $translator;
    public function __construct(TranslatorInterface $translatorInterface)
    {
        $this->translator = $translatorInterface;
    }
    /**
     * @Route("/admin/annonceur", name="annonceur_index")
     */
    public function index(): Response
    {
        return $this->render('admin/annonceur/index.html.twig', [
            'controller_name' => 'AnnonceurController',
        ]);
    }
    /**
     * @Route("/admin/annonceur/new", name="annonceur_new")
     */
    public function new(): Response
    {
        return $this->render('admin/annonceur/new.html.twig', [
        ]);
    }

}
