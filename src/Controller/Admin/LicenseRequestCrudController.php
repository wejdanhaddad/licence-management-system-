<?php

namespace App\Controller\Admin;

use App\Entity\LicenseRequest;
use App\Entity\License;
use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class LicenseRequestCrudController extends AbstractCrudController
{
    private $httpClient;
    private $em;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $em)
    {
        $this->httpClient = $httpClient;
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return LicenseRequest::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('client'),
            AssociationField::new('product'),
            ChoiceField::new('status')->setChoices([
                'En attente' => 'pending',
                'Approuvée' => 'approved',
                'Rejetée' => 'rejected'
            ]),
            TextField::new('licenseKey'),
            DateTimeField::new('createdAt'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $approve = Action::new('approve', 'Approuver', 'fa fa-check')
            ->linkToRoute('admin_approve_request', function(LicenseRequest $r) { return ['id' => $r->getId()]; })
            ->displayIf(function(LicenseRequest $r) { return $r->getStatus() === 'pending'; });

        $reject = Action::new('reject', 'Rejeter', 'fa fa-times')
            ->linkToRoute('admin_reject_request', function(LicenseRequest $r) { return ['id' => $r->getId()]; })
            ->displayIf(function(LicenseRequest $r) { return $r->getStatus() === 'pending'; });

        $generate = Action::new('generate', 'Générer', 'fa fa-key')
            ->linkToRoute('admin_generate_license', function(LicenseRequest $r) { return ['id' => $r->getId()]; })
            ->displayIf(function(LicenseRequest $r) { return $r->getStatus() === 'approved' && !$r->getLicenseKey(); });

        $activate = Action::new('activate', 'Activer', 'fa fa-play')
            ->linkToRoute('admin_activate_license', function(LicenseRequest $r) { return ['key' => $r->getLicenseKey()]; })
            ->displayIf(function(LicenseRequest $r) { return $r->getLicenseKey(); });

        $deactivate = Action::new('deactivate', 'Désactiver', 'fa fa-stop')
            ->linkToRoute('admin_deactivate_license', function(LicenseRequest $r) { return ['key' => $r->getLicenseKey()]; })
            ->displayIf(function(LicenseRequest $r) { return $r->getLicenseKey(); });

        $block = Action::new('block', 'Bloquer', 'fa fa-ban')
            ->linkToRoute('admin_block_license', function(LicenseRequest $r) { return ['key' => $r->getLicenseKey()]; })
            ->displayIf(function(LicenseRequest $r) { return $r->getLicenseKey(); });

        return $actions
            ->add(Crud::PAGE_INDEX, $approve)
            ->add(Crud::PAGE_INDEX, $reject)
            ->add(Crud::PAGE_INDEX, $generate)
            ->add(Crud::PAGE_INDEX, $activate)
            ->add(Crud::PAGE_INDEX, $deactivate)
            ->add(Crud::PAGE_INDEX, $block);
    }

    /**
     * @Route("/admin/license-request/generate/{id}", name="admin_generate_license")
     */
    public function generateLicense($id): RedirectResponse
    {
        $request = $this->em->getRepository(LicenseRequest::class)->find($id);

        if (!$request || $request->getStatus() !== 'approved') {
            $this->addFlash('danger', 'Demande invalide ou non approuvée.');
            return $this->redirectToRoute('admin_dashboard');
        }

        $payload = [
            'clientId' => (string) ($request->getMachineId()),
            'productId' => (string) ($request->getProduct()->getName()),
            'licenseType' => 'standard',
            'maxActivations' => 3,
            'startDate' => ($request->getStartDate() ?? new \DateTime())->format('Y-m-d\TH:i:s'),
            'endDate' => ($request->getEndDate() ?? new \DateTime('+1 year'))->format('Y-m-d\TH:i:s'),
        ];

        try {
            $response = $this->httpClient->request('POST', 'http://localhost:5000/api/license/generate', [
                'json' => $payload
            ]);

            $data = json_decode($response->getContent(false), true);

            if (!isset($data['LicenseKey'])) {
                $this->addFlash('danger', 'Erreur : La clé de licence n’a pas été générée.');
                return $this->redirectToRoute('admin_dashboard');
            }

            $licenseKey = $data['LicenseKey'];
        } catch (\Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface $e) {
            $this->addFlash('danger', 'Erreur API : ' . $e->getMessage());
            return $this->redirectToRoute('admin_dashboard');
        }

        $user = $request->getClient(); // retourne un User
$client = $this->em->getRepository(Client::class)->findOneBy(['user' => $user]);

if (!$client) {
    $this->addFlash('danger', 'Client introuvable pour cet utilisateur.');
    return $this->redirectToRoute('admin_dashboard');
}


        $license = new License();
        $license->setLicenseKey($licenseKey);
        $license->setActive(true);
        $license->setDateCreation(new \DateTime());
        $license->setDateExpiration(new \DateTime('+1 year'));
        $license->setClient($client);
        $license->setProduct($request->getProduct());

        $request->setLicenseKey($licenseKey);
        $request->setStatus('approved');

        $this->em->persist($license);
        $this->em->flush();

        $this->addFlash('success', 'Licence générée et enregistrée avec succès.');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/admin/license-request/approve/{id}", name="admin_approve_request")
     */
    public function approveRequest(int $id): RedirectResponse
    {
        $request = $this->em->getRepository(LicenseRequest::class)->find($id);
        if (!$request) {
            $this->addFlash('danger', 'Demande introuvable.');
            return $this->redirectToRoute('admin_dashboard');
        }

        $request->setStatus('approved');
        $this->em->flush();

        $this->addFlash('success', 'Demande approuvée.');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/admin/license-request/reject/{id}", name="admin_reject_request")
     */
    public function rejectRequest(int $id): RedirectResponse
    {
        $request = $this->em->getRepository(LicenseRequest::class)->find($id);
        if (!$request) {
            $this->addFlash('danger', 'Demande introuvable.');
            return $this->redirectToRoute('admin_dashboard');
        }

        $request->setStatus('rejected');
        $this->em->flush();

        $this->addFlash('info', 'Demande rejetée.');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/admin/license-request/activate/{key}", name="admin_activate_license")
     */
    public function activateLicense(string $key): RedirectResponse
    {
        $this->httpClient->request('POST', 'http://localhost:5000/api/license/activate/' . $key);
        $this->addFlash('info', 'Licence activée.');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/admin/license-request/deactivate/{key}", name="admin_deactivate_license")
     */
    public function deactivateLicense(string $key): RedirectResponse
    {
        $this->httpClient->request('POST', 'http://localhost:5000/api/license/deactivate/' . $key);
        $this->addFlash('warning', 'Licence désactivée.');
        return $this->redirectToRoute('admin_dashboard');
    }

    /**
     * @Route("/admin/license-request/block/{key}", name="admin_block_license")
     */
    public function blockLicense(string $key): RedirectResponse
    {
        $this->httpClient->request('POST', 'http://localhost:5000/api/license/block/' . $key);
        $this->addFlash('warning', 'Licence bloquée.');
        return $this->redirectToRoute('admin_dashboard');
    }
}
