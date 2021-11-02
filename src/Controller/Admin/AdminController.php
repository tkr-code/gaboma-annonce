<?php

namespace App\Controller\Admin;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class AdminController extends AbstractController
{
    private $translator;
    public function __construct(TranslatorInterface $translatorInterface)
    {
     $this->translator = $translatorInterface;   
    }
    /**
     * @Route("/admin/", name="admin")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'parent_page' =>$this->translator->trans('Dashboard'),
            'en_attente'=>$annonceRepository->etat('En attente')
        ]);
    }
}
