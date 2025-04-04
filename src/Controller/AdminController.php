<?php

namespace App\Controller;

use App\Entity\License;
use App\Entity\User;
use App\Entity\Paiement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_ADMIN')] // Seuls les admins peuvent accéder
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin_dashboard')]
    public function index(EntityManagerInterface $entityManager)
    {
        $nbUsers = $entityManager->getRepository(User::class)->count([]);
        $nbLicenses = $entityManager->getRepository(License::class)->count([]);
        $revenus = $entityManager->getRepository(Paiement::class)->createQueryBuilder('p')
            ->select('SUM(p.montant)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('admin/dashboard.html.twig', [
            'nbUsers' => $nbUsers,
            'nbLicenses' => $nbLicenses,
            'revenus' => $revenus,
        ]);
    }
    #[Route('/users', name: 'admin_users')]
public function manageUsers(EntityManagerInterface $entityManager)
{
    $users = $entityManager->getRepository(User::class)->findAll();
    return $this->render('admin/users.html.twig', ['users' => $users]);
}

#[Route('/licenses', name: 'admin_licenses')]
public function manageLicenses(EntityManagerInterface $entityManager)
{
    $licenses = $entityManager->getRepository(License::class)->findAll();
    return $this->render('admin/licenses.html.twig', ['licenses' => $licenses]);
}

#[Route('/paiements', name: 'admin_paiements')]
public function viewPaiements(EntityManagerInterface $entityManager)
{
    $paiements = $entityManager->getRepository(Paiement::class)->findAll();
    return $this->render('admin/paiements.html.twig', ['paiements' => $paiements]);
}

}
