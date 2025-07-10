<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\LicenseRequest;
use App\Controller\Admin\UserCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;
use App\Entity\ContentBlock; // Assurez-vous que cette ligne est bien présente

class DashboardController extends AbstractDashboardController
{
    /**
     * Tableau de Bord - Page principale
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(): Response
    {
        // Redirige par défaut vers la liste des utilisateurs lors de l'accès au tableau de bord.
        $routeBuilder = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect(
            $routeBuilder->setController(UserCrudController::class)->generateUrl()
        );
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="/uploads/twinkle.png" alt="Twinkle" height="80"> </span>')
            ->renderContentMaximized()
            ->generateRelativeUrls()
            ->setFaviconPath('/uploads/favicon.ico');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Gestion');    
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Clients', 'fas fa-building', Client::class);
        yield MenuItem::linkToCrud('Demandes de licences', 'fas fa-envelope', LicenseRequest::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-box-open', Produit::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-folder-open', Category::class);    
        yield MenuItem::section('Contenu & Navigation'); 
        yield MenuItem::linkToCrud('Blocs de contenu', 'fas fa-file-alt', ContentBlock::class); 
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-globe', 'app_home');
        yield MenuItem::linkToLogout('Déconnexion', 'fas fa-sign-out-alt');
    }
}