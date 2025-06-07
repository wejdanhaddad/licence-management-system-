<?php

namespace App\Controller\Admin;


use App\Entity\Produit;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\License;
use App\Entity\LicenseRequest;
use App\Controller\Admin\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;


class DashboardController extends AbstractDashboardController
{
    /**
     * Tableau de Bord - Page principale
     * @Route("/admin", name="admin_dashboard")
     */

    public function index(): Response
    {
        
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect(
            $routeBuilder->setController(UserCrudController::class)->generateUrl()
        );
    }
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/uploads/twinkle.jpg" alt="Twinkle" height="80"> </span>')
            ->renderContentMaximized()
            ->generateRelativeUrls()
            ->setFaviconPath('/uploads/favicon.ico');
    }
    public function configureMenuItems(): iterable
    {
        
        
        yield MenuItem::section('Gestion');
        
        yield MenuItem::linkToCrud(' Utilisateurs', 'fas fa-users', User::class);
         yield MenuItem::linkToCrud('Clients', 'fas fa-building', Client::class);
         yield MenuItem::linkToCrud('Demandes de licences', 'fas fa-envelope', LicenseRequest::class);
        yield MenuItem::linkToCrud(' Produits', 'fas fa-box-open', Produit::class);
        yield MenuItem::linkToCrud(' Catégories', 'fas fa-folder-open', Category::class);
        yield MenuItem::linkToCrud(' licenses', 'fas fa-key', License::class);
       
        yield MenuItem::section('Navigation');
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-globe', 'app_home');
    }
}