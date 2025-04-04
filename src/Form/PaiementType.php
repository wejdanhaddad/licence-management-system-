<?php

namespace App\Form;

use App\Entity\Paiement;
use App\Entity\User;
use App\Entity\License;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', MoneyType::class, [
                'currency' => 'EUR',
                'label' => 'Montant du paiement'
            ])
            ->add('datePaiement', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date du paiement'
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'label' => 'Utilisateur'
            ])
            ->add('license', EntityType::class, [
                'class' => License::class,
                'choice_label' => 'nom',
                'label' => 'Licence'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer le paiement',
                'attr' => ['class' => 'btn btn-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
