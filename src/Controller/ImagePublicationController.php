<?php

namespace App\Controller;

use App\Entity\ImagePublication;
use App\Form\ImagePublicationType;
use App\Repository\ImagePublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/image/publication")
 */
class ImagePublicationController extends AbstractController
{
    /**
     * @Route("/", name="image_publication_index", methods={"GET"})
     */
    public function index(ImagePublicationRepository $imagePublicationRepository): Response
    {
        return $this->render('image_publication/index.html.twig', [
            'image_publications' => $imagePublicationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="image_publication_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $imagePublication = new ImagePublication();
        $form = $this->createForm(ImagePublicationType::class, $imagePublication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($imagePublication);
            $entityManager->flush();

            return $this->redirectToRoute('image_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('image_publication/new.html.twig', [
            'image_publication' => $imagePublication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_publication_show", methods={"GET"})
     */
    public function show(ImagePublication $imagePublication): Response
    {
        return $this->render('image_publication/show.html.twig', [
            'image_publication' => $imagePublication,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="image_publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ImagePublication $imagePublication): Response
    {
        $form = $this->createForm(ImagePublicationType::class, $imagePublication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('image_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('image_publication/edit.html.twig', [
            'image_publication' => $imagePublication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="image_publication_delete", methods={"POST"})
     */
    public function delete(Request $request, ImagePublication $imagePublication): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagePublication->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($imagePublication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('image_publication_index', [], Response::HTTP_SEE_OTHER);
    }
}
