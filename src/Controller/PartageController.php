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
use App\Form\PartageType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartageController extends AbstractController
{
    /**
     * @Route("/partage", name="partage")
     */
    public function index(int $id=1 ,Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository): Response
    {
        $user = $this->getUser();
        $menus = $typeprojetRepository->findAll();
        $rubriques = $rubriqueRepository->findAll();
        $publication = new Publication();
        $form = $this->createForm(PartageType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form['photo']->getData();
            if($image){
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('image'),
                    $newFilename
                );
                $publication->setImage($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $publication->setUser($user);
            $publication->setDate(new \DateTime());
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('liste');
        }
        return $this->render('partage/index.html.twig', [
            'controller_name' => 'Publication',
            //'publications' => $publication,
            'menus' => $menus,
            'rubriques' => $rubriques,
            'form' => $form->createView(),
        ]);
    }
}
