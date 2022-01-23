<?php

namespace App\Controller\Main;

use App\Entity\AnnonceSearch;
use App\Form\AppSearchType;
use App\Repository\CategoryParentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryParentRepository $categoryParentRepository, Request $request): Response
    {
        $search = new AnnonceSearch();
        $form = $this->createForm(AppSearchType::class, $search)->handleRequest($request);

        return $this->renderForm('main/home/index.html.twig', [
            'form'=>$form,
            'parents'=>$categoryParentRepository->findAll()

        ]);
    }
}