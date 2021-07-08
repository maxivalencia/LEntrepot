<?php

namespace App\Controller;

use App\Entity\Typeproposition;
use App\Form\TypepropositionType;
use App\Repository\TypepropositionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/typeproposition")
 */
class TypepropositionController extends AbstractController
{
    /**
     * @Route("/", name="typeproposition_index", methods={"GET"})
     */
    public function index(TypepropositionRepository $typepropositionRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $typepropositionRepository->findBy([], ["id" => "DESC"]), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return $this->render('typeproposition/index.html.twig', [
            'typepropositions' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="typeproposition_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typeproposition = new Typeproposition();
        $form = $this->createForm(TypepropositionType::class, $typeproposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeproposition);
            $entityManager->flush();

            return $this->redirectToRoute('typeproposition_index');
        }

        return $this->render('typeproposition/new.html.twig', [
            'typeproposition' => $typeproposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typeproposition_show", methods={"GET"})
     */
    public function show(Typeproposition $typeproposition): Response
    {
        return $this->render('typeproposition/show.html.twig', [
            'typeproposition' => $typeproposition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="typeproposition_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Typeproposition $typeproposition): Response
    {
        $form = $this->createForm(TypepropositionType::class, $typeproposition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeproposition_index');
        }

        return $this->render('typeproposition/edit.html.twig', [
            'typeproposition' => $typeproposition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="typeproposition_delete", methods={"POST"})
     */
    public function delete(Request $request, Typeproposition $typeproposition): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeproposition->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeproposition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('typeproposition_index');
    }
}
