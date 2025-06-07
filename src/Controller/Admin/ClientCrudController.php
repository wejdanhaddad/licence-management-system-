<?php
namespace App\Controller\Admin;


use App\Entity\Client;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\HttpFoundation\Request;
use App\Form\GenerateLicenseType;
use Symfony\Component\Form\FormFactoryInterface;


class ClientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Client::class;
    }
        public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('companyName', 'Société'),
            TextField::new('address', 'Adresse'),
            TextField::new('phone', 'Téléphone'),
            AssociationField::new('user', 'Utilisateur'),
            AssociationField::new('licenses', 'Licences')->onlyOnDetail()
        ];
    }
    public function configureActions(Actions $actions): Actions
{
    $viewDetails = Action::new('viewDetails', ' Voir détails')
        ->linkToRoute('admin_client_detail', function (Client $client) {
            return ['id' => $client->getId()];
        });
    return $actions->add(Crud::PAGE_INDEX, $viewDetails);
}
/**
 * @Route("/admin/client/{id}/details", name="admin_client_detail")
 */
public function clientDetails(Client $client, Request $request, FormFactoryInterface $formFactory): Response
{
    $form = $this->createForm(GenerateLicenseType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $product = $form->get('product')->getData();
        return $this->redirectToRoute('admin_generate_license_for_client', [
            'id' => $client->getId(),
            'productId' => $product->getId(),
        ]);
    }
    return $this->render('admin/client_details.html.twig', [
        'client' => $client,
        'licenses' => $client->getLicenses(),
        'form' => $form->createView(),
    ]);
}
}
