<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom du produit'),
            TextEditorField::new('description', 'Description'),
            MoneyField::new('prix', 'Prix')->setCurrency('EUR'), // ou 'TND'
            ImageField::new('image', 'Image')
                ->setBasePath('/uploads/produits')
                ->setUploadDir('public/uploads/produits')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->setRequired(false),
            AssociationField::new('category', 'Catégorie'),
            AssociationField::new('license', 'Licence associée'),
            TextField::new('versionActuelle', 'Version actuelle'),
            TextField::new('typeLicence', 'Type de licence'),
            DateTimeField::new('dateCreation', 'Date de création')->setFormat('dd/MM/yyyy HH:mm'),
            DateTimeField::new('dateDerniereMiseAJour', 'Date de dernière mise à jour')->setFormat('dd/MM/yyyy HH:mm'),
            BooleanField::new('statut', 'Statut'),
            
            DateTimeField::new('createdAt', 'Date de création')->hideOnForm(),
            
        ];
    }
}

