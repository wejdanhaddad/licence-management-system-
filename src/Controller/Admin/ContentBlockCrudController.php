<?php

namespace App\Controller\Admin;

use App\Entity\ContentBlock;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContentBlockCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContentBlock::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('identifier')
                ->setHelp('Une clé unique pour identifier ce bloc (par exemple, notre_mission, contact_intro).'),
            // CORRECTION: Utilisez 'titre' au lieu de 'title' pour correspondre à votre entité
            TextField::new('titre'),
            // CORRECTION: Utilisez 'contenu' au lieu de 'content' pour correspondre à votre entité
            TextEditorField::new('contenu')
                ->setHelp('Le contenu riche pour cette section.'),
        ];
    }
}