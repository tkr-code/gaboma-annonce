<?php

namespace App\Controller\User;

use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/annonce")
 */
class UserAnnonceController extends AbstractController
{
    /**
     * @Route("/", name="user_annonce_index", methods={"GET"})
     */
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('user/annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }
    /**
     * @Route("/en-ligne", name="user_annonce_en_ligne", methods={"GET"})
     */
    public function enLigne(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('user/annonce/en-ligne.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_annonce_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    // /**
    //  * @Route("/{id}", name="annonce_show", methods={"GET"})
    //  */
    // public function show(Annonce $annonce): Response
    // {
    //     return $this->render('admin/annonce/show.html.twig', [
    //         'annonce' => $annonce,
    //     ]);
    // }

    // /**
    //  * @Route("/{id}/edit", name="annonce_edit", methods={"GET","POST"})
    //  */
    // public function edit(Request $request, Annonce $annonce): Response
    // {
    //     $form = $this->createForm(AnnonceType::class, $annonce);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $this->getDoctrine()->getManager()->flush();

    //         return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('admin/annonce/edit.html.twig', [
    //         'annonce' => $annonce,
    //         'form' => $form,
    //     ]);
    // }

    // /**
    //  * @Route("/{id}", name="annonce_delete", methods={"POST"})
    //  */
    // public function delete(Request $request, Annonce $annonce): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($annonce);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
    // }
}
