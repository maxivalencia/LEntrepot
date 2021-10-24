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
use App\Entity\Proposition;
use App\Repository\PropositionRepository;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/offre")
 */
class OffreController extends AbstractController
{
    /**
     * @Route("/", name="offre", methods={"GET","POST"})
     */
    public function index(int $id=1 ,Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository, PaginatorInterface $paginator): Response
    {
        $id = $request->query->get('id');
        $menus = $typeprojetRepository->findAll();
        //$rubriques = $rubriqueRepository->findAll();
        $rubriques = $rubriqueRepository->findBy([],["nom" => "ASC"]);
        $titre_rubrique = $rubriqueRepository->findOneBy(['id' => $id]);
        //$publication = $publicationRepository->findBy(['rubrique' => $id]);
        $publication = $paginator->paginate(
            $publicationRepository->findBy(['rubrique' => $id]), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'Publication',
            'publications' => $publication,
            'menus' => $menus,
            'rubriques' => $rubriques,
            'titre_rubrique' => $titre_rubrique,
        ]);
    }

    
    /**
     * @Route("/details", name="details", methods={"GET","POST"})
     */
    public function details(int $id=1 ,Request $request, PropositionRepository $propositionRepository, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository, PaginatorInterface $paginator): Response
    {
        $id = $request->query->get('id');
        $publication = $publicationRepository->findOneBy(['id' => $id]);
        $menus = $typeprojetRepository->findAll();
        //$rubriques = $rubriqueRepository->findAll();
        $rubriques = $rubriqueRepository->findBy([],["nom" => "ASC"]);
        $titre_rubrique = $publication->getRubrique();
        $proposition = $paginator->paginate(
            $propositionRepository->findBy(['publication' => $publication]), /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return $this->render('offre/detailsoffre.html.twig', [
            'controller_name' => 'Publication',
            'publication' => $publication,
            'menus' => $menus,
            'rubriques' => $rubriques,
            'titre_rubrique' => $titre_rubrique,
            'propositions' => $proposition,
        ]);
    }

    /**
     * @Route("/propose", name="propose", methods={"POST"})
     */
    public function propose(Request $request, PublicationRepository $publicationRepository): Response
    {
        $nouvelleProposition = $request->request->get('proposition');
        $proposition = new Proposition();
        $proposition->setProposition($nouvelleProposition);
        $proposition->setDate(new \DateTime());
        $publication = $publicationRepository->findOneBy(["id" => $request->request->get('publication')]);
        $proposition->setPublication($publication);
        $proposition->setUser($this->getUser());
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($proposition);
        $entityManager->flush();
        return $this->redirectToRoute('details', [
            "id" => $request->request->get('publication'),
        ]);
    }
}
