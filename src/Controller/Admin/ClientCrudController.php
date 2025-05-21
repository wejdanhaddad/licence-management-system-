<?php
 namespace App\Controller\Admin;

use App\Entity\Client;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField; // à ajouter
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\EntityManagerInterface;

class ClientCrudController extends AbstractCrudController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getEntityFqcn(): string
    {
        return Client::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('username', 'Nom d\'utilisateur'),
            EmailField::new('email', 'Email'),
            // Utilise PasswordType pour le formulaire, mais ne mappe pas directement à la propriété
            ChoiceField::new('roles', 'Rôle')
            ->allowMultipleChoices(true)
            ->autocomplete()
            ->setChoices([
                'Client' => 'ROLE_CLIENT',
                'Administrateur' => 'ROLE_ADMIN',
            ]),
            TextField::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->setFormTypeOption('mapped', false)
                ->setLabel('Password'), // Label pour le formulaire
        ];

        if ($pageName === Crud::PAGE_NEW || $pageName === Crud::PAGE_EDIT) {
             $fields[] = TextField::new('plainPassword')
                ->setFormType(PasswordType::class)
                ->setFormTypeOption('mapped', false)
                ->setLabel('Password');
        }

        return $fields;
    }

    public function createEntity(string $entityFqcn)
    {
        $client = new Client();
        $client->setRoles(['ROLE_CLIENT']);
        // Set a random password.
        $client->setPassword('TempPassword');
        return $client;
    }
    


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityManager, $entityInstance);
        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->encodePassword($entityManager, $entityInstance);
        parent::persistEntity($entityManager, $entityInstance);
    }

    private function encodePassword(EntityManagerInterface $entityManager, Client $client): void
    {
         if ($client->getPlainPassword()) {
            $encodedPassword = $this->passwordEncoder->encodePassword($client, $client->getPlainPassword());
            $client->setPassword($encodedPassword);
         }
    }
}

