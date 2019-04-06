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
     * @Route("/api/signin", name="api_signin", methods={"POST"}))
     */
    public function signin(
        Request $request,
        JsonResponse $jsonResponse,
        IAuthenticateService $authenticateService
    ) {
        try {
            $user = new User(
                $request->get('username'),
                $request->get('password')
            );

            $token = $authenticateService
                ->authenticate($user)
                ->getToken();

            $jsonResponse
                ->setData(['token' => $token])
                ->setStatusCode($jsonResponse::HTTP_CREATED);

        } catch (\Exception $ex) {
        }
        return $jsonResponse;
    }
}
