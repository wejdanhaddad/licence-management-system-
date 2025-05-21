<?php

namespace App\Controller\Admin;

use App\Entity\License;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
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
            IdField::new('id')->onlyOnIndex(), // Display only in the list view
            TextField::new('licenseKey', 'Clé de licence'), // Updated to match the entity
            BooleanField::new('active', 'Active'),
            DateTimeField::new('dateCreation', 'Créée le'),
            DateTimeField::new('dateExpiration', 'Expire le'),
            AssociationField::new('client', 'Client associé') // Links to the Client entity
        ];
    }
}