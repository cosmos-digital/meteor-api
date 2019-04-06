<?php

namespace App\Controller;

use App\Application\Service\IAccountCreateService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/api/signup", name="api_account_create", methods={"POST"}))
     */
    public function signup(
        Request $request,
        JsonResponse $jsonResponse,
        IAccountCreateService $accountCreateService
    ) {
        try {
            $password_encode = password_hash($request->get('password'), PASSWORD_BCRYPT);
            $user = new User(
                $request->get('username'),
                $password_encode
            );

            $user->password_repeat = $password_encode;

            $accountCreateService->create($user);

        } catch (\Exception $ex) {
            \var_dump($ex);
        }
        return $jsonResponse;
    }
}
