<?php

namespace App\Controller\Main;

use App\Entity\Annonce;
use App\Entity\AnnonceSearch;
use App\Form\AnnonceSearchType;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryParentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends AbstractController
{
    /**
     * @Route("/annonces", name="annonces")
     * @Route("/annonces/{parent}", name="annonces_categorie")
     */
    public function index(AnnonceRepository $annonceRepository,string $parent = null,CategoryParentRepository $categoryParentRepository, PaginatorInterface $paginator, Request $request): Response
    {
        

        $categoryParentRepository->findOneBy([
            'name'=>$parent
        ]);
        
        $search = new AnnonceSearch();
        $form = $this->createForm(AnnonceSearchType::class, $search)->handleRequest($request);
        
        $pagination = $paginator->paginate(
            $annonceRepository->search($search),
            $request->query->getInt('page',1),
            12
        );
        return $this->renderForm('main/annonce/index.html.twig', [
            'form'=>$form,
            'annonces' => $pagination,
            'parent'=>$parent,
            'parents'=>$categoryParentRepository->findAll()
        ]);
    }
    /**
     * @Route("/annonces-details/{slug}/{id}", name="annonce_detail")
     */
    public function detail(Annonce $annonce, string $slug): Response
    {
        if($slug !== $annonce->getSlug()){
            return $this->redirectToRoute('annonce_detail',[
                'slug'=>$annonce->getSlug(),
                'id'=>$annonce->getId()
            ],301);
        }
        return $this->renderForm('main/annonce/detail.html.twig', [
            'annonce'=>$annonce
        ]);
    }
}
