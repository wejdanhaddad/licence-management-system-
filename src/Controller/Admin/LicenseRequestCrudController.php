<?php

namespace App\Controller\Admin;

use App\Entity\LicenseRequest;
use App\Entity\License;
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
        $generate = Action::new('generate', 'Générer', 'fa fa-key')
            ->linkToRoute('admin_generate_license', function(LicenseRequest $req) { return ['id' => $req->getId()]; })
            ->displayIf(function(LicenseRequest $req) { return $req->getStatus() === 'approved' && !$req->getLicenseKey(); });

        $activate = Action::new('activate', 'Activer', 'fa fa-play')
            ->linkToRoute('admin_activate_license', function(LicenseRequest $req) { return ['key' => $req->getLicenseKey()]; })
            ->displayIf(function(LicenseRequest $req) { return $req->getLicenseKey(); });

        $deactivate = Action::new('deactivate', 'Désactiver', 'fa fa-stop')
            ->linkToRoute('admin_deactivate_license', function(LicenseRequest $req) { return ['key' => $req->getLicenseKey()]; })
            ->displayIf(function(LicenseRequest $req) { return $req->getLicenseKey(); });

        $block = Action::new('block', 'Bloquer', 'fa fa-ban')
            ->linkToRoute('admin_block_license', function(LicenseRequest $req) { return ['key' => $req->getLicenseKey()]; })
            ->displayIf(function(LicenseRequest $req) { return $req->getLicenseKey(); });

        return $actions
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

    // Préparation des données pour l’API
    $payload = [
        $payload = [
    'clientId' => $request->getMachineId(), // ✅ Correct maintenant
    'productId' => $request->getProduct()->getName(), // ou getId() si l'API le demande
    'licenseType' => 'standard',
    'maxActivations' => 3,
    'startDate' => ($request->getStartDate() ?: new \DateTime())->format('Y-m-d\TH:i:s'),
    'endDate' => ($request->getEndDate() ?: new \DateTime('+1 year'))->format('Y-m-d\TH:i:s'),
]
    ];

    try {
        $response = $this->httpClient->request('POST', 'http://localhost:5000/api/license/generate', [
            'json' => $payload
        ]);

        // Afficher le contenu brut de l’API pour analyse
        $rawContent = $response->getContent(false); // Pas d'exception automatique
        $data = json_decode($rawContent, true);

        // Vérifie si une clé de licence a été retournée
        if (!isset($data['licenseKey'])) {
            $this->addFlash('danger', 'Erreur : La clé de licence n’a pas été générée.');
            dump($data); // Débogue les erreurs API
            die();
        }

        $licenseKey = $data['licenseKey'];
    } catch (\Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface $e) {
        $this->addFlash('danger', 'Erreur API : ' . $e->getMessage());
        dump($e->getResponse()->getContent(false)); // Affiche le contenu brut de l’erreur
        die();
    }

    // Crée une nouvelle licence dans Symfony
    $license = new License();
    $license->setLicenseKey($licenseKey);
    $license->setActive(true);
    $license->setDateCreation(new \DateTime());
    $license->setDateExpiration(new \DateTime('+1 year'));
    $license->setClient($request->getClient());
    $license->setProduct($request->getProduct());

    // Met à jour la demande de licence
    $request->setLicenseKey($licenseKey);
    $request->setStatus('approved');

    $this->em->persist($license);
    $this->em->flush();

    $this->addFlash('success', 'Licence générée et enregistrée avec succès.');
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
