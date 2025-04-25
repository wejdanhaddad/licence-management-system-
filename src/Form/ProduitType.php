<?php 
namespace App\Form;

use App\Entity\Category;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('image', FileType::class, [
            'label' => 'Image du produit',
            'mapped' => false, // ne lier pas directement à l'entité
            'required' => false, // rend le champ facultatif
            'attr' => ['class' => 'form-control']
        ])

            ->add('name', TextType::class, [
                'label' => 'Nom du produit',
                'attr' => ['placeholder' => 'Entrez le nom du produit', 'class' => 'form-control'],
                'constraints' => [new NotBlank(['message' => 'Le nom du produit est obligatoire.'])]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['placeholder' => 'Décrivez le produit...', 'class' => 'form-control', 'rows' => 4],
                'constraints' => [new NotBlank(['message' => 'La description est obligatoire.'])]
            ])
            ->add('versionActuelle', TextType::class, [
                'label' => 'Version Actuelle',
                'attr' => ['placeholder' => 'Ex: 1.0.0', 'class' => 'form-control']
            ])
            ->add('typeLicence', ChoiceType::class, [
                'label' => 'Type de Licence',
                'choices' => [
                    'Gratuite' => 'gratuite',
                    'Standard' => 'standard',
                    'Pro' => 'pro',
                    'Entreprise' => 'entreprise'
                ],
                'expanded' => false,
                'multiple' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateCreation', DateTimeType::class, [
                'label' => 'Date de Création',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateDerniereMiseAJour', DateTimeType::class, [
                'label' => 'Date de Dernière Mise à Jour',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('statut', CheckboxType::class, [
                'label' => 'Produit Actif',
                'required' => false
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
                'attr' => ['placeholder' => 'Entrez le prix du produit', 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Le prix est obligatoire.']),
                    new GreaterThanOrEqual(['value' => 0, 'message' => 'Le prix doit être supérieur ou égal à 0.'])
                ]
            ])
            ->add('modulesInclus', CollectionType::class, [
                'label' => 'Modules Inclus',
                'entry_type' => TextType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('conditionsUtilisation', TextareaType::class, [
                'label' => 'Conditions d\'Utilisation',
                'attr' => ['placeholder' => 'Règles et restrictions d’usage...', 'class' => 'form-control']
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'titre',
                'label' => 'Catégorie',
                'placeholder' => 'Sélectionnez une catégorie',
                'attr' => ['class' => 'form-control']
                
            ])
            ->add('image', FileType::class, [
                'label' => 'Image du produit',
                'required' => false,
                'mapped' => false, // Important pour les uploads
                'attr' => [
                    'accept' => 'image/*'
                ]]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
