<?php

namespace App\Form;

use App\Entity\LicenseRequest;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class LicenseRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'name',
                'label' => 'Produit',
            ])
            ->add('machineId', TextType::class, [
    'label' => 'Identifiant de machine',
    'required' => true,
])

            ->add('requestType', ChoiceType::class, [
                'choices' => [
                    'Activation' => 'activation',
                    'Renouvellement' => 'renouvellement',
                    'Désactivation' => 'désactivation',
                ],
                'label' => 'Type de demande',
            ])
            ->add('message', TextareaType::class, [
                'required' => false,
                'label' => 'Message (optionnel)',
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'required' => false
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'required' => false
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LicenseRequest::class,
        ]);
    }
}
