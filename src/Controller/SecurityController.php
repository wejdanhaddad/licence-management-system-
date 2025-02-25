<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error,
        ]);
    }


    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        // This method can be blank - Symfony handles the logout automatically
        throw new \LogicException('This should never be called directly.');
    }

    /**
     * @Route("/security", name="security_registration")
     */
    public function registration(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        // Create a new User object
        $user = new User();

        // Create the registration form
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        // If the form is submitted and valid, process the data
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the password
            $hashedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Save the user to the database
            $entityManager->persist($user);
            $entityManager->flush();

            // Add a success flash message
            $this->addFlash('success', 'Registration successful!');

            // Redirect to the homepage or login page
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
