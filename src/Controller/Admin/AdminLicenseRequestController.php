<?php

namespace App\Controller\Admin;

use App\Entity\LicenseRequest;
use App\Service\LicenseApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Client;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("/admin/license")
 */
class AdminLicenseRequestController extends AbstractController
{
    /**
     * @Route("/approve/{id}", name="admin_license_approve")
     */
    public function approve(LicenseRequest $licenseRequest, LicenseApiService $api, EntityManagerInterface $em)
    {
       $data = [
    'clientId' => $licenseRequest->getMachineId(), 
    'productId' => $licenseRequest->getProduct()->getName(), 
    'licenseType' => 'standard',
    'maxActivations' => 3,
    'startDate' => $licenseRequest->getCreatedAt()->format('c'), 
    'endDate' => (new \DateTime('+1 year'))->format('c'),
];
        $response = $api->generateLicense($data);
        $licenseRequest->setStatus('approved');
        $licenseRequest->setLicenseKey($response['licenseKey'] ?? null);
        $em->flush();

        $this->addFlash('success', 'Licence générée avec succès');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/reject/{id}", name="admin_license_reject")
     */
    public function reject(LicenseRequest $licenseRequest, EntityManagerInterface $em)
    {
        $licenseRequest->setStatus('rejeter');
        $em->flush();

        $this->addFlash('info', 'Demande rejetée');
        return $this->redirectToRoute('admin_dashboard');
    }
    /**
 * @Route("/admin/client/{id}/generate-license", name="admin_generate_license_for_client")
 */
public function generateLicenseForClient(Client $client, Request $request, LicenseApiService $api, EntityManagerInterface $em): Response
{
    $productId = $request->query->get('productId');
    $machineId = $request->query->get('machineId'); // récupéré depuis formulaire ou URL
    if (!$machineId) {
        $this->addFlash('danger', 'Identifiant de machine manquant.');
        return $this->redirectToRoute('admin_client_detail', ['id' => $client->getId()]);
    }
    $product = $em->getRepository(\App\Entity\Produit::class)->find($productId);
    if (!$product) {
        $this->addFlash('danger', 'Produit non trouvé.');
        return $this->redirectToRoute('admin_client_detail', ['id' => $client->getId()]);
    }
    $data = [
        'clientId' => $machineId,
        'productId' => $product->getName(), 
        'licenseType' => 'standard',
        'maxActivations' => 3,
        'startDate' => (new \DateTime())->format('c'),
        'endDate' => (new \DateTime('+1 year'))->format('c'),
    ];
    try {
        $response = $api->generateLicense($data);
    } catch (\Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface $e) {
        $errorContent = $e->getResponse()->getContent(false);
        $this->addFlash('danger', 'Erreur API : ' . $errorContent);
        return $this->redirectToRoute('admin_client_detail', ['id' => $client->getId()]);
    }
    $license = new \App\Entity\License();
    $license->setLicenseKey($response['licenseKey'] ?? null);
    $license->setActive(true);
    $license->setDateCreation(new \DateTime());
    $license->setDateExpiration(new \DateTime('+1 year'));
    $license->setClient($client);
    $license->setProduct($product);
    $em->persist($license);
    $em->flush();
    $this->addFlash('success', 'Licence générée avec succès.');
    return $this->redirectToRoute('admin_client_detail', ['id' => $client->getId()]);
}    
}
