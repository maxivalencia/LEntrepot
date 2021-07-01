<?php

namespace App\Controller;

use App\Entity\Typeprojet;
use App\Form\TypeprojetType;
use App\Repository\TypeprojetRepository;
use App\Entity\Rubrique;
use App\Form\RubriqueType;
use App\Repository\RubriqueRepository;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
{
    /**
     * @Route("/", name="offre", methods={"GET","POST"})
     */
    public function index(int $id=1 ,Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository): Response
    {
        $id = $request->query->get('id');
        $menus = $typeprojetRepository->findAll();
        $rubriques = $rubriqueRepository->findAll();
        $titre_rubrique = $rubriqueRepository->findOneBy(['id' => $id]);
        $publication = $publicationRepository->findBy(['rubrique' => $id]);
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'Publication',
            'publications' => $publication,
            'menus' => $menus,
            'rubriques' => $rubriques,
            'titre_rubrique' => $titre_rubrique,
        ]);
    }
}
