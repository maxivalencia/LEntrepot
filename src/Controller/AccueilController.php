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
use App\Entity\Partenaire;
use App\Form\PartenaireType;
use App\Repository\PartenaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository, PartenaireRepository $partenaireRepository): Response
    {
        $menus = $typeprojetRepository->findAll();
        $rubriques = $rubriqueRepository->findAll();
        $partenaires = $partenaireRepository->findBy([],["id" => "DESC"]);
        $i = 0;
        $liste_partenaires = [];
        foreach ($partenaires as $partenaire) {
            if ($i < 5) {
                // exit;
                $liste_partenaires[$i] = $partenaire;
                $i++;
            }
        }
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'Accueil',
            'menus' => $menus,
            'rubriques' => $rubriques,
            'partenaires' => $liste_partenaires,
        ]);
    }

    /**
     * @Route("/accueil/test", name="accueil2", methods={"GET","POST"})
     */
    public function accueil(Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository): Response
    {
        $menus = $typeprojetRepository->findAll();
        $rubriques = $rubriqueRepository->findAll();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'Accueil',
            'menus' => $menus,
            'rubriques' => $rubriques,
        ]);
    }

    /**
     * @Route("/enpublication/{id}", name="enpublication", methods={"GET","POST"})
     */
    public function enpublication(int $id ,Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository): Response
    {
        $menus = $typeprojetRepository->findAll();
        $rubriques = $rubriqueRepository->findAll();
        $titre_rubrique = $rubriqueRepository->findOneBy(['id' => $id]);
        $publication = $publicationRepository->findBy(['rubrique' => $id]);
        return $this->render('accueil/offre.html.twig', [
            'controller_name' => 'Publication',
            'publication' => $publication,
            'menus' => $menus,
            'rubriques' => $rubriques,
            'titre_rubrique' => $titre_rubrique,
        ]);
    }

    /**
     * @Route("/admin/", name="admin", methods={"GET","POST"})
     */
    public function admin(): Response
    {
        return $this->render('accueil/admin.html.twig', [
            'controller_name' => 'Publication',
        ]);
    }
}
