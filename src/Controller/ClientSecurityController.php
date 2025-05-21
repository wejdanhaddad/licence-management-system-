<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class ClientSecurityController extends AbstractController
{
    /**
     * @Route("/client/login", name="client_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
{
    // Redirect logged-in users to their profile
    if ($this->getUser()) {
        return $this->redirectToRoute('client_profile');
    }
    $error = $authenticationUtils->getLastAuthenticationError();
    $lastUsername = $authenticationUtils->getLastUsername();
    return $this->render('client/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error,
    ]);
}
    /**
     * @Route("client/profile", name="profile")
     */
    public function profile(): Response
    {
        $client = $this->getUser();

        return $this->render('client/profile.html.twig', [
            'client' => $client,
        ]);
    }
    /**
     * @Route("/logout", name="client_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}
