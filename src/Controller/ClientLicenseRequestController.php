<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\LicenseRequest;
use App\Form\LicenseRequestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientLicenseRequestController extends AbstractController
{
    /**
     * @Route("/client/license-request", name="client_license_request")
     */
    public function requestLicense(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser(); // Utilisateur connecté
        $client = $em->getRepository(Client::class)->findOneBy(['user' => $user]);

        if (!$client) {
            $this->addFlash('danger', 'Aucun client associé à cet utilisateur.');
            return $this->redirectToRoute('app_home');
        }

        $licenseRequest = new LicenseRequest();
        $licenseRequest->setClient($client);

        $form = $this->createForm(LicenseRequestType::class, $licenseRequest);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($licenseRequest);
            $em->flush();

            $this->addFlash('success', 'Votre demande de licence a été envoyée avec succès.');
            return $this->redirectToRoute('client_license_request');
        }

        return $this->render('client/license_request.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
