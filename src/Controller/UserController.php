<?php

namespace App\Controller;

use App\Application\Service\IEntityValidateService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user", name="api_user_create", methods={"POST"}))
     */
    public function create(
        Request $request,
        IEntityValidateService $validator,
        JsonResponse $jsonResponse
    ) {
        try {
            $user = new User(
                $request->get('username'),
                $request->get('password')
            );

            $user->password_repeat = $request->get('password_repeat');

            $validator->validate($user);

        } catch (\Exception $ex) {

        }
        return $jsonResponse;
    }
}
