<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\LicenseRequest;
use App\Form\LicenseRequestType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $user = $this->getUser();

            if (method_exists($user, 'getIsAdministrative') && $user->getIsAdministrative()) {
                return $this->redirectToRoute('admin_dashboard');
            } else {
                return $this->redirectToRoute('profile');
            }
        }

        $error = $authenticationUtils->getLastAuthenticationError();
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
        throw new \LogicException('This should never be called directly.');
    }

    /**
     * @Route("/security", name="security_registration")
     * @IsGranted("ROLE_ADMIN")
     */
    public function registration(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        MailerInterface $mailer
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifie si un utilisateur avec le même email existe
            $existingUser = $entityManager->getRepository(User::class)->findOneBy([
                'email' => $user->getEmail()
            ]);

            if ($existingUser) {
                $this->addFlash('error', 'Un compte avec cet email existe déjà.');
                return $this->redirectToRoute('security_registration');
            }

            // Encodage du mot de passe
            $hashedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            // Définir le rôle
            $user->setRoles([$user->getIsAdministrative() ? 'ROLE_ADMIN' : 'ROLE_USER']);

            $entityManager->persist($user);
            $entityManager->flush();

            // Envoi de l'e-mail de confirmation
            try {
                $email = (new Email())
                    ->from('no-reply@votredomaine.com')
                    ->to($user->getEmail())
                    ->subject('Confirmation de votre inscription')
                    ->html($this->renderView(
                        'emails/registration_confirmation.html.twig',
                        [
                            'user' => $user,
                            'isAdmin' => $user->getIsAdministrative()
                        ]
                    ));

                $mailer->send($email);

                $this->addFlash('success', 'Inscription réussie ! Un email de confirmation a été envoyé.');
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('warning', 'Inscription réussie, mais l\'email de confirmation n\'a pas pu être envoyé.');
            }

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("client/profile", name="profile")
     */
    public function profile(Request $request, EntityManagerInterface $em): Response
    {
        $client = $this->getUser();

        if ($client instanceof User && $client->getIsAdministrative()) {
            return $this->redirectToRoute('admin_dashboard');
        }

        if (!$client instanceof User) {
            throw $this->createAccessDeniedException('Accès réservé aux clients.');
        }

        $licenseRequest = new LicenseRequest();
        $licenseRequest->setClient($client);

        $form = $this->createForm(LicenseRequestType::class, $licenseRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($licenseRequest);
            $em->flush();

            $this->addFlash('success', 'Votre demande a été envoyée avec succès.');
            return $this->redirectToRoute('profile');
        }

        return $this->render('client/profile.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
        ]);
    }
}
