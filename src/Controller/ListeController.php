<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\ImagePublication;
use App\Repository\PublicationRepository;
use App\Repository\RubriqueRepository;
use App\Repository\TypeprojetRepository;
use App\Repository\ImagePublicationRepository;
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
    public function index(Request $request, ImagePublicationRepository $imagePublicationRepository, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository, PaginatorInterface $paginator): Response
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
        foreach($listes as $pub){
            $images = $imagePublicationRepository->findOneBy(['referenceImage' => $pub->getImage()]);
            if($images != NULL){
                $pub->setImage($images->getNomServer());
            }
        }
        return $this->render('liste/index.html.twig', [
            'controller_name' => 'Liste publication',
            'listes' => $listes,
            'menus' => $menus,
            'rubriques' => $rubriques,
        ]);
    }

    /**
     * @Route("/migra_data_table", name="migrate_table")
     */
    public function migrate_table(ImagePublicationRepository $imagePublicationRepository, PublicationRepository $publicationRepository)
    {
        $listes = $publicationRepository->findAll();
        $entityManager = $this->getDoctrine()->getManager();
        foreach($listes as $list){
            $image = new ImagePublication();
            $im = $imagePublicationRepository->findOneBy(["referenceImage" => $list->getImage()]);
            if($im == NULL){ 
                $image->setNomFichier($list->getImage());
                $image->setNomServer($list->getImage());
                $image->setReferenceImage($list->getImage());
                $entityManager->persist($image);
            }
        }
        $entityManager->flush();
        return $this->redirectToRoute('liste');
    }
}
