<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/* use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;  
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;                 
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtilsInterface;*/

use App\Service\LicenseApiService;

#[Route('/licence')]
class LicenseController extends AbstractController
{
    #[Route('/check/{key}', name: 'check_license')]
    public function check(LicenseApiService $api, string $key): Response
    {
        $result = $api->checkLicense($key);
        return $this->render('license/check.html.twig', [
            'result' => $result,
        ]);
    }

    #[Route('/activate/{key}', name: 'activate_license')]
    public function activate(LicenseApiService $api, string $key): Response
    {
        $message = $api->activateLicense($key);
        return $this->render('license/activate.html.twig', [
            'message' => $message,
        ]);
    }
}
