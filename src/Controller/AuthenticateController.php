<?php

namespace App\Controller;

use App\Application\Service\IAuthenticateService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthenticateController extends AbstractController
{
    /**
     * @Route("/api/login", name="api_login", methods={"POST"}))
     */
    public function login(
        Request $request,
        IAuthenticateService $authenticateService
    ) {
        $user = new User(
            $request->get('username'),
            $request->get('password')
        );

        $token = $authenticateService
            ->authenticate($user)
            ->getToken();

        return new JsonResponse(['token' => $token]);
    }
}
