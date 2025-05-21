<?php
namespace App\Form;

use App\Entity\License;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LicenseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('licenseKey', TextType::class, [
                'label' => 'License Key',
            ])
            ->add('expirationDate', DateTimeType::class, [
                'label' => 'Expiration Date',
                'widget' => 'single_text',
            ])
            ->add('client', EntityType::class, [
                'label' => 'Client',
                'class' => Client::class,
                'choice_label' => 'username', // Adjust this to the property you want to display
            ])
            ->add('active', CheckboxType::class, [
                'label' => 'Active',
                'required' => false,
            ])
            ->add('dateCreation', DateTimeType::class, [
                'label' => 'Date of Creation',
                'widget' => 'single_text',
            ])
            ->add('dateExpiration', DateTimeType::class, [
                'label' => 'Date of Expiration',
                'widget' => 'single_text',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save License',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => License::class,
        ]);
    }
}