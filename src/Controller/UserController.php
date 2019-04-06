<?php

namespace App\Controller;

use App\Application\Service\IUserDeleteService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route(
     *      "/api/user/{uid}",
     *      name="api_user_delete",
     *      methods={"DELETE"},
     *      requirements={"uid" = "[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}"}
     * )
     */
    public function delete(
        string $uid,
        JsonResponse $jsonResponse,
        IUserDeleteService $userDeleteService
    ) {
        try {
            $userDeleteService->deleteByUid($uid);
        } catch (\Exception $ex) {
        }
        return $jsonResponse;
    }
}
