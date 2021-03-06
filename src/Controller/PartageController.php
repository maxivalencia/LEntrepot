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
use App\Entity\ImagePublication;
use App\Form\ImagePublicationType;
use App\Repository\ImagePublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class PartageController extends AbstractController
{
    /**
     * @Route("/partage", name="partage", methods={"GET","POST"})
     */
    public function index(int $id=1 ,Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository): Response
    {
        $user = $this->getUser();
        $menus = $typeprojetRepository->findAll();
        //$rubriques = $rubriqueRepository->findAll();
        $rubriques = $rubriqueRepository->findBy([],["nom" => "ASC"]);
        $publication = new Publication();
        $form = $this->createForm(PartageType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* $image = $form['photo']->getData();
            if($image){
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('image'),
                    $newFilename
                );
                $publication->setImage($newFilename);
            } */
            $entityManager = $this->getDoctrine()->getManager();
            $publication->setUser($user);
            $publication->setDate(new \DateTime());
            $image_publication = $request->request->get("fileref");
            $publication->setImage($image_publication);
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('liste');
        }
        $daty = new \DateTime(); //this returns the current date time
        $results = $daty->format('Y-m-d-H-i-s');
        $krr = explode('-', $results);
        $results = implode("", $krr).$this->generateUniqueFileName();
        return $this->render('partage/index.html.twig', [
            'controller_name' => 'Publication',
            //'publications' => $publication,
            'menus' => $menus,
            'rubriques' => $rubriques,
            'form' => $form->createView(),
            'refimage' => $results,
        ]);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/upload_file/{ref}", name="upload_file", methods={"GET","POST"})
     */
    public function upload_file(Request $request, $ref): Response
    {
        $imagePublication = new ImagePublication(); 
        $entityManager = $this->getDoctrine()->getManager();   
        $file = $request->files->get('myfile');
        $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
        $file->move(
            $this->getParameter('image_publication'),
            $fileName
        );
        $reference = $ref;//$request->request->get('piecejointes');
        $daty   = new \DateTime(); //this returns the current date time
        $results = $daty->format('Y-m-d-H-i-s');
        $krr    = explode('-', $results);
        $results = implode("", $krr);
        $imagePublication->setNomFichier($file->getClientOriginalName()); // mila maka an'ilay reference sy ilay vraie nom de fichier
        $imagePublication->setNomServer($fileName);
        $imagePublication->setReferenceImage($reference);
        $entityManager->persist($imagePublication);
        $entityManager->flush();
        return new JsonResponse(['filesnames' => $results]);
            
    }
}
