<?php

namespace App\Controller\Admin;

use App\Entity\Credit;
use App\Form\CreditType;
use App\Repository\CreditRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/credit")
 */
class CreditController extends AbstractController
{
    private $parent_page = 'Crédit';
    /**
     * @Route("/mes-credits", name="credit_index", methods={"GET"})
     */
    public function myCredit(CreditRepository $creditRepository): Response
    {
        return $this->render('admin/credit/my.html.twig', [
            'credits_on' => $creditRepository->isUse(true,$this->getUser()),
            'credits_off' => $creditRepository->isUse(false,$this->getUser()),
            'parent_page'=>'Mes Crédits'
        ]);
    }
    /**
     * @Route("/", name="admin_credit_index", methods={"GET"})
     */
    public function index(CreditRepository $creditRepository): Response
    {
        return $this->render('admin/credit/index.html.twig', [
            'credits' => $creditRepository->findAll(),
            'parent_page'=>$this->parent_page
        ]);
    }

    /**
     * @Route("/new", name="admin_credit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $credit = new Credit();
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($credit);
            $entityManager->flush();

            return $this->redirectToRoute('admin_credit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/credit/new.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_credit_show", methods={"GET"})
     */
    public function show(Credit $credit): Response
    {
        return $this->render('admin/credit/show.html.twig', [
            'credit' => $credit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_credit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Credit $credit): Response
    {
        $form = $this->createForm(CreditType::class, $credit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_credit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/credit/edit.html.twig', [
            'credit' => $credit,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_credit_delete", methods={"POST"})
     */
    public function delete(Request $request, Credit $credit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$credit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($credit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_credit_index', [], Response::HTTP_SEE_OTHER);
    }
}
