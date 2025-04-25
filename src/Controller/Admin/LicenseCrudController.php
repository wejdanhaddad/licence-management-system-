<?php

namespace App\Controller\Admin;

use App\Entity\License;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class LicenseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return License::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('cle', 'Clé de licence'),
            BooleanField::new('active', 'Active'),
            DateTimeField::new('dateCreation', 'Créée le'),
            DateTimeField::new('dateExpiration', 'Expire le'),
            AssociationField::new('client', 'Client associé')
        ];
    
        return $crud->setEntityLabelInPlural('Licences')
                    ->setEntityLabelInSingular('Licence')
                    ->setPageTitle('index', '🔐 Gestion des Licences')
                    ->setPageTitle('edit', '✏️ Modifier la licence')
                    ->setPageTitle('new', '➕ Nouvelle licence');
    }
}
