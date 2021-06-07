<?php

namespace App\Controller;

use App\Entity\Typeprojet;
use App\Form\TypeprojetType;
use App\Repository\TypeprojetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/typeprojet")
 */
class TypeprojetController extends AbstractController
{
    /**
     * @Route("/", name="typeprojet_index", methods={"GET"})
     */
    public function index(TypeprojetRepository $typeprojetRepository): Response
    {
        return $this->render('typeprojet/index.html.twig', [
            'typeprojets' => $typeprojetRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="typeprojet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeprojet = new Typeprojet();
        $form = $this->createForm(TypeprojetType::class, $typeprojet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeprojet);
            $entityManager->flush();

            return $this->redirectToRoute('typeprojet_index');
        }

        return $this->render('typeprojet/new.html.twig', [
            'typeprojet' => $typeprojet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typeprojet_show", methods={"GET"})
     */
    public function show(Typeprojet $typeprojet): Response
    {
        return $this->render('typeprojet/show.html.twig', [
            'typeprojet' => $typeprojet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="typeprojet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Typeprojet $typeprojet): Response
    {
        $form = $this->createForm(TypeprojetType::class, $typeprojet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeprojet_index');
        }

        return $this->render('typeprojet/edit.html.twig', [
            'typeprojet' => $typeprojet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typeprojet_delete", methods={"POST"})
     */
    public function delete(Request $request, Typeprojet $typeprojet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeprojet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeprojet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('typeprojet_index');
    }
}
