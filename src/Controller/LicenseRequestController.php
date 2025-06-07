<?php

namespace App\Controller;

use App\Entity\LicenseRequest;
use App\Form\LicenseRequestType;
use App\Repository\LicenseRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/license/request")
 */
class LicenseRequestController extends AbstractController
{
    /**
     * @Route("/", name="app_license_request_index", methods={"GET"})
     */
    public function index(LicenseRequestRepository $licenseRequestRepository): Response
    {
        return $this->render('license_request/index.html.twig', [
            'license_requests' => $licenseRequestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_license_request_new", methods={"GET", "POST"})
     */
    public function new(Request $request, LicenseRequestRepository $licenseRequestRepository): Response
    {
        $licenseRequest = new LicenseRequest();
        $form = $this->createForm(LicenseRequestType::class, $licenseRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $licenseRequestRepository->add($licenseRequest);
            return $this->redirectToRoute('app_license_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('license_request/new.html.twig', [
            'license_request' => $licenseRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_license_request_show", methods={"GET"})
     */
    public function show(LicenseRequest $licenseRequest): Response
    {
        return $this->render('license_request/show.html.twig', [
            'license_request' => $licenseRequest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_license_request_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, LicenseRequest $licenseRequest, LicenseRequestRepository $licenseRequestRepository): Response
    {
        $form = $this->createForm(LicenseRequestType::class, $licenseRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $licenseRequestRepository->add($licenseRequest);
            return $this->redirectToRoute('app_license_request_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('license_request/edit.html.twig', [
            'license_request' => $licenseRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="app_license_request_delete", methods={"POST"})
     */
    public function delete(Request $request, LicenseRequest $licenseRequest, LicenseRequestRepository $licenseRequestRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$licenseRequest->getId(), $request->request->get('_token'))) {
            $licenseRequestRepository->remove($licenseRequest);
        }

        return $this->redirectToRoute('app_license_request_index', [], Response::HTTP_SEE_OTHER);
    }
}
