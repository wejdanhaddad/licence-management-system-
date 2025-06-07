<?php
namespace App\Form;

use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenerateLicenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'name',
                'label' => 'Produit à associer',
                'placeholder' => 'Sélectionnez un produit',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        // pas besoin de data_class ici, car on ne lie pas directement à une entité
    }
}
