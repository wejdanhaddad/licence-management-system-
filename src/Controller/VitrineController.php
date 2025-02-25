<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\License;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\ServiceType;
use App\Form\LicenseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class VitrineController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $services = $entityManager->getRepository(Service::class)->findBy([], ['name' => 'ASC']);

        return $this->render('vitrine/index.html.twig', [
            'services' => $services,
        ]);
    }

    /**
     * @Route("/services/{id}", name="service_details", requirements={"id"="\d+"})
     */
    public function serviceDetails(int $id, EntityManagerInterface $entityManager): Response
    {
        $service = $entityManager->getRepository(Service::class)->find($id);

        if (!$service) {
            $this->addFlash('error', 'Service introuvable.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('vitrine/service_details.html.twig', [
            'service' => $service,
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('vitrine/contact.html.twig');
    }

    /**
     * @Route("/admin/licenses", name="admin_licenses", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function manageLicenses(Request $request, EntityManagerInterface $entityManager): Response
    {
        $license = new License();
        $form = $this->createForm(LicenseType::class, $license);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($license);
            $entityManager->flush();
            $this->addFlash('success', 'Licence ajoutée avec succès.');

            return $this->redirectToRoute('admin_licenses');
        }

        $licenses = $entityManager->getRepository(License::class)->findAll();
        return $this->render('admin/licenses.html.twig', [
            'licenses' => $licenses,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/api/licenses", name="api_licenses", methods={"GET"})
     */
    public function getLicenses(EntityManagerInterface $entityManager): Response
    {
        $licenses = $entityManager->getRepository(License::class)->findAll();
        return $this->json($licenses);
    }

    /**
     * @Route("/services", name="service_list")
     */
    public function listServices(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Création du formulaire de recherche par catégorie
        $form = $this->createFormBuilder()
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'titre',
                'placeholder' => 'Sélectionnez une catégorie',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('search', SubmitType::class, [
                'label' => '🔍 Rechercher',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->getForm();

        $form->handleRequest($request);

        // Récupération des services avec ou sans filtre
        $queryBuilder = $entityManager->getRepository(Service::class)->createQueryBuilder('s');

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->get('category')->getData();
            if ($category) {
                $queryBuilder->where('s.category = :category')
                    ->setParameter('category', $category);
            }
        }

        $services = $queryBuilder->getQuery()->getResult();
        $categories = $entityManager->getRepository(Category::class)->findAll();

        return $this->render('vitrine/listServices.html.twig', [
            'services' => $services,
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categories", name="category_list")
     */
    public function listCategories(EntityManagerInterface $entityManager): Response
    {
        try {
            $categories = $entityManager->getRepository(Category::class)->findBy([], ['titre' => 'ASC']);
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('vitrine/listCategories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/services/new", name="new_service")
     */
    public function newService(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'Service ajouté avec succès !');
            return $this->redirectToRoute('service_list');
        }

        return $this->render('vitrine/newService.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categories/new", name="new_category")
     */
    public function newCategory(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Catégorie ajoutée avec succès !');
            return $this->redirectToRoute('category_list');
        }

        return $this->render('vitrine/new_category.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
 * @Route("/about", name="about_page")
 */
public function about(): Response
{
    return $this->render('vitrine/about.html.twig');
}

}
