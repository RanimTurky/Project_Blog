<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // Créer une nouvelle instance de l'entité User
        $user = new User();

        // Créer un formulaire d'inscription à partir de RegistrationType
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        // Traiter le formulaire lorsqu'il est soumis
        if ($form->isSubmitted() && $form->isValid()) {
            // Encodage du mot de passe
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Enregistrement de l'utilisateur dans la base de données
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Redirection après l'inscription (ajustez la route selon vos besoins)
            return $this->redirectToRoute('accueil');
        }

        // Affichage du formulaire d'inscription
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
