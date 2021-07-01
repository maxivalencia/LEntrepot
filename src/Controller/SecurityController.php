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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET","POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils, int $id=1 ,Request $request, PublicationRepository $publicationRepository, TypeprojetRepository $typeprojetRepository, RubriqueRepository $rubriqueRepository): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $id = $request->query->get('id');
        $menus = $typeprojetRepository->findAll();
        $rubriques = $rubriqueRepository->findAll();
        //$titre_rubrique = $rubriqueRepository->findOneBy(['id' => $id]);
        //$publication = $publicationRepository->findBy(['rubrique' => $id]);
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error,
            'controller_name' => 'Login',
            //'publications' => $publication,
            'menus' => $menus,
            'rubriques' => $rubriques,
            //'titre_rubrique' => $titre_rubrique,
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
