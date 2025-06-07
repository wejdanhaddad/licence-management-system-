<?php

namespace App\Controller;
use App\Entity\Produit;
use App\Entity\Contact;
use App\Entity\Faq;
use App\Entity\License;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\ContactType;
use App\Form\ProduitType;
use App\Form\LicenseType;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\ElseIf_;
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
 * 🏠 Accueil - Page principale
 * @Route("/", name="app_home")
 */

    public function index(EntityManagerInterface $entityManager): Response
{
    // 🔐 Rediriger les administrateurs vers leur dashboard
    if ($this->getUser()) {
        $user = $this->getUser();
        // Redirection selon la propriété isadmin (ou isAdministrative)
        if (method_exists($user, 'getIsAdministrative()') && $user->getIsAdministrative()) {
            return $this->redirectToRoute('admin_dashboard'); // Mets ici la route de ton dashboard admin
        } else {
            return $this->redirectToRoute('client_profile'); // Mets ici la route du profil client
        }}
    $produits = $entityManager->getRepository(Produit::class)->findBy([], ['name' => 'ASC']); // Assure-toi que c'est bien 'nom' dans ta base

    $features = [
        ['icon' => 'fas fa-key', 'title' => 'Clés Automatiques', 'description' => 'Création et distribution instantanée de licences.'],
        ['icon' => 'fas fa-lock', 'title' => 'Sécurité Renforcée', 'description' => 'Protection contre le piratage avec vérification via API.'],
        ['icon' => 'fas fa-user-cog', 'title' => 'Gestion Client', 'description' => 'Suivi des demandes et visualisation des licences.'],
    ];
    
$testimonials = [
    ['text' => '"Un outil efficace pour gérer nos licences en toute simplicité."', 'author' => 'A. B.'],
    ['text' => '"Une interface claire, intuitive et fluide. Bravo !"', 'author' => 'M. T.'],
    ['text' => '"Une solution moderne et bien pensée."', 'author' => 'C. K.'],
];
$faqs = $entityManager->getRepository(Faq::class)->findAll();

return $this->render('vitrine/index.html.twig', [
    'produits' => $produits,
    'testimonials' => $testimonials, // ✅ Ensure this is passed
    'features' => $features,
    'faqs' => $faqs, 
]);


    
}
    /**
     * 📦 Détails d’un produit
     * @Route("/produit/{id}", name="produit_details", requirements={"id"="\d+"})
     */
    public function produitDetails(int $id, EntityManagerInterface $entityManager): Response
    {
        $produit = $entityManager->getRepository(Produit::class)->find($id);

        if (!$produit) {
            $this->addFlash('error', 'Produit introuvable.');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('vitrine/service_details.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * 🔍 Liste des produits par catégorie
     * @Route("/produits", name="produit_list")
     */
    public function listProduits(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder()
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'titre', // Modification de 'nom' à 'titre'
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

        $queryBuilder = $entityManager->getRepository(Produit::class)->createQueryBuilder('p');

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->get('category')->getData();
            if ($category) {
                $queryBuilder->where('p.category = :category')
                    ->setParameter('category', $category);
            }
        }
        $produits = $queryBuilder->getQuery()->getResult();
        $categories = $entityManager->getRepository(Category::class)->findBy([], ['titre' => 'ASC']); // Modification de 'nom' à 'titre'
        return $this->render('vitrine/listProduit.html.twig', [
            'produits' => $produits,
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }
    /**
     * 📂 Liste des catégories de produits
     * @Route("/categories", name="category_list")
     */
    public function listCategories(EntityManagerInterface $entityManager): Response
    {
        try {
            $categories = $entityManager->getRepository(Category::class)->findBy([], ['titre' => 'ASC']); // Modification de 'nom' à 'titre'
        } catch (\Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('vitrine/listCategories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
 * ➕ Ajouter un nouveau produit
 * @Route("/produits/new", name="new_produit")
 */
public function newProduit(Request $request, EntityManagerInterface $entityManager): Response
{
    $produit = new Produit();
    $form = $this->createForm(ProduitType::class, $produit);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        /** @var UploadedFile $imageFile */
        $imageFile = $form->get('image')->getData();
        
        if ($imageFile) {
            $newFilename = uniqid().'.'.$imageFile->guessExtension();
            
            // Déplacez le fichier
            $imageFile->move(
                $this->getParameter('upload_directory'),
                $newFilename
            );
            
            $produit->setImage($newFilename);
        }

        $entityManager->persist($produit);
        $entityManager->flush();

        $this->addFlash('success', 'Produit ajouté avec succès !');
        return $this->redirectToRoute('produit_list');
    }

    return $this->render('vitrine/newService.html.twig', [
        'form' => $form->createView(),
    ]);
}

    /**
     * ➕ Ajouter une nouvelle catégorie
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
     * 📄 À propos
     * @Route("/about", name="about_page")
     */
    public function about(): Response
    {
        return $this->render('vitrine/about.html.twig');
    }
    /**
     * 📩 Contact
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            $this->addFlash('success', 'Votre message a été envoyé avec succès !');
            return $this->redirectToRoute('contact');
        }
        return $this->render('vitrine/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}