<?php

namespace App\Controller\Admin;

use App\Repository\AnnonceRepository;
use App\Repository\UserRepository;
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
     * @Route("/my-account/", name="admin")
     */
    public function index(UserRepository $userRepository, AnnonceRepository $annonceRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'parent_page' =>$this->translator->trans('Dashboard'),
            'en_attente'=>$annonceRepository->etat('En attente'),
            'mes_annonces'=>$annonceRepository->user($this->getUser()),
            'annonces'=>$annonceRepository->findAll(),
            'nb_users'=>count($userRepository->findAll())
        ]);
    }
}
