<?php

namespace App\Controller;

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
        $licenseRequest = new LicenseRequest();
        $licenseRequest->setClient($this->getUser());

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
