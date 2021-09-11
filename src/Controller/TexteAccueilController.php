<?php

namespace App\Controller;

use App\Entity\TexteAccueil;
use App\Form\TexteAccueilType;
use App\Repository\TexteAccueilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/texte/accueil")
 */
class TexteAccueilController extends AbstractController
{
    /**
     * @Route("/", name="texte_accueil_index", methods={"GET"})
     */
    public function index(TexteAccueilRepository $texteAccueilRepository): Response
    {
        return $this->render('texte_accueil/index.html.twig', [
            'texte_accueils' => $texteAccueilRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="texte_accueil_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $texteAccueil = new TexteAccueil();
        $form = $this->createForm(TexteAccueilType::class, $texteAccueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($texteAccueil);
            $entityManager->flush();

            return $this->redirectToRoute('texte_accueil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('texte_accueil/new.html.twig', [
            'texte_accueil' => $texteAccueil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="texte_accueil_show", methods={"GET"})
     */
    public function show(TexteAccueil $texteAccueil): Response
    {
        return $this->render('texte_accueil/show.html.twig', [
            'texte_accueil' => $texteAccueil,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="texte_accueil_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TexteAccueil $texteAccueil): Response
    {
        $form = $this->createForm(TexteAccueilType::class, $texteAccueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('texte_accueil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('texte_accueil/edit.html.twig', [
            'texte_accueil' => $texteAccueil,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="texte_accueil_delete", methods={"POST"})
     */
    public function delete(Request $request, TexteAccueil $texteAccueil): Response
    {
        if ($this->isCsrfTokenValid('delete'.$texteAccueil->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($texteAccueil);
            $entityManager->flush();
        }

        return $this->redirectToRoute('texte_accueil_index', [], Response::HTTP_SEE_OTHER);
    }
}
