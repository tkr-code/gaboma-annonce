<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use App\Entity\Annonce;
use App\Entity\Image;
use App\Form\AnnonceurType;
use App\Repository\AnnonceRepository;

class AnnonceurController extends AbstractController
{
    private $translator;
    private $parent_page = 'Publication';
    public function __construct(TranslatorInterface $translatorInterface)
    {
        $this->translator = $translatorInterface;
    }
    /**
     * @Route("/admin/annonceur", name="annonceur_index")
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $user = $this->getUser();
        return $this->render('admin/annonceur/index.html.twig', [
            'parent_page' => $this->parent_page,
            'en_attente'=>$annonceRepository->etat('En attente',$user),
            'en_ligne'=>$annonceRepository->etat('En ligne',$user,)
        ]);
    }
    /**
     * @Route("/admin/annonceur/new", name="annonceur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonce();
        $annonce->setUser($this->getUser());
        $form = $this->createForm(AnnonceurType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();

            foreach( $images as $image)
            {
                $fichier = md5(uniqid()). '.'.$image->guessExtension();  
                $image->move(
                    $this->getParameter('annonce_images_directory'),
                    $fichier
                );
                $img = new Image();
                $img->setName($fichier);
                $annonce->addImage($img);
            }
            $entityManager = $this->getDoctrine()->getManager();
            // dd($annonce);
            $entityManager->persist($annonce);
            $entityManager->flush();

            $this->addFlash('success','Annonce crée et mise en attente');

            return $this->redirectToRoute('annonceur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/annonceur/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("admin/annonceur/{id}", name="annonceur_show", methods={"GET"})
     */
    public function show(Annonce $annonce): Response
    {
        return $this->render('admin/annonceur/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

}
