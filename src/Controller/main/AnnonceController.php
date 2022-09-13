<?php

namespace App\Controller\Main;

use App\Entity\Annonce;
use App\Entity\AnnonceSearch;
use App\Entity\CategoryParent;
use App\Form\AnnonceSearchType;
use App\Form\AppSearchType;
use App\Repository\AnnonceRepository;
use App\Repository\CategoryParentRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Expr\Instanceof_;
use Symfony\Component\HttpFoundation\Request;

class AnnonceController extends AbstractController
{

    /**
     * @Route("/toutes-les-annonces", name="annonces")
     * @Route("/toutes-les-annonces/{parent}", name="annonces_parent")
     * @Route("/toutes-les-annonces/{parent}/{categorie}", name="annonces_categorie")
     */
    public function index(CategoryRepository $categoryRepository, AnnonceRepository $annonceRepository,string $categorie =null, string $parent = null,CategoryParentRepository $categoryParentRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $parentCategorie =  $parent = $categoryParentRepository->findOneBy([
                'name'=>$parent
            ]);
        $search = new AnnonceSearch();
        if($categorie){
            $categorie = str_replace('_',' ',$categorie);
            $categorie = $categoryRepository->findOneBy([
                'name'=>$categorie
            ]);
            $search->setCategory($categorie->getId());
        }        
        $form = $this->createForm(AppSearchType::class, $search)->handleRequest($request);
        
        $pagination = $paginator->paginate(
            $annonceRepository->search($search),
            $request->query->getInt('page',1),
            12
        );
        // $pagination = $paginator->paginate(
        //     $annonceRepository->parentCategorie($search),
        //     $request->query->getInt('page',1),
        //     12
        // );

        return $this->renderForm('main/annonce/index.html.twig', [
            'form'=>$form,
            'annonces' => $pagination,
            'parent'=>$parentCategorie,
            'parents'=>$categoryParentRepository->findAll()
        ]);
    }
    /**
     * @Route("/annonces-details/{slug}/{id}", name="annonce_detail")
     */
    public function show(Annonce $annonce, string $slug): Response
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
