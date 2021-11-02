<?php

namespace App\Controller\Main;

use App\Entity\AnnonceSearch;
use App\Form\AnnonceSearchType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonces", name="annonces")
     */
    public function index(AnnonceRepository $annonceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $search = new AnnonceSearch();
        $id_category = $request->query->get('category');
        $search->setCategory($id_category);
        $form = $this->createForm(AnnonceSearchType::class, $search)->handleRequest($request);
        $pagination = $paginator->paginate(
            $annonceRepository->search(
                $search->getMots(),
                $search->getCategory(),
                $search->getMinPrice(),
                $search->getMaxPrice()
            ),
            $request->query->getInt('page',1),
            12
        );
        return $this->renderForm('main/annonce/index.html.twig', [
            'form'=>$form,
            'annonces' => $pagination
        ]);
    }
    /**
     * @Route("/annonces-details/{{slug}}/{id}}", name="annonce_detail")
     */
    public function detail(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('main/annonce/detail.html.twig', [
            'annonces' => $annonceRepository->etat('En attente')
        ]);
    }
}
