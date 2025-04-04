<?php

namespace App\Controller;
use App\Entity\Paiement;
use App\Form\PaiementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/paiement')]
class PaiementController extends AbstractController
{
    #[Route('/new', name: 'paiement_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $paiement = new Paiement();
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($paiement);
            $entityManager->flush();

            $this->addFlash('success', 'Paiement enregistré avec succès.');
            return $this->redirectToRoute('paiement_list');
        }

        return $this->render('paiement/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/list', name: 'paiement_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $paiements = $entityManager->getRepository(Paiement::class)->findAll();
        return $this->render('paiement/list.html.twig', [
            'paiements' => $paiements,
        ]);
    }
}
