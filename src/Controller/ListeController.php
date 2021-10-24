<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Repository\PublicationRepository;
use App\Repository\RubriqueRepository;
use App\Repository\TypeprojetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class ListeController extends AbstractController
{
    /**
     * @Route("/liste", name="liste")
     */
    public function index(Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository, PaginatorInterface $paginator): Response
    {
        $user = $this->getUser();
        $menus = $typeprojetRepository->findAll();
        //$rubriques = $rubriqueRepository->findAll();
        $rubriques = $rubriqueRepository->findBy([],["nom" => "ASC"]);
        $listes = $paginator->paginate(
            $publicationRepository->findBy(['user' => $user]), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return $this->render('liste/index.html.twig', [
            'controller_name' => 'Liste publication',
            'listes' => $listes,
            'menus' => $menus,
            'rubriques' => $rubriques,
        ]);
    }
}
