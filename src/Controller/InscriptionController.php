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
use App\Form\InscriptionType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(int $id=1 ,Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository): Response
    {
        $id = $request->query->get('id');
        $menus = $typeprojetRepository->findAll();
        //$rubriques = $rubriqueRepository->findAll();
        $rubriques = $rubriqueRepository->findBy([],["nom" => "ASC"]);
        //$titre_rubrique = $rubriqueRepository->findOneBy(['id' => $id]);
        //$publication = $publicationRepository->findBy(['rubrique' => $id]);
        
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setRoles(['ROLE_CLIENT']);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            ));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }
        return $this->render('inscription/index.html.twig', [
            'controller_name' => 'Inscription',
            //'publications' => $publication,
            'menus' => $menus,
            'rubriques' => $rubriques,
            //'titre_rubrique' => $titre_rubrique,
            'form' => $form->createView(),
        ]);
    }
}
