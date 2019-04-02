<?php
namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\User;

class ApiController extends Controller
{
    /**
     * @Route("/api/login_check", name="api_login_check")
     */
    public function getTokenUser(
        Request $request,
        JWTTokenManagerInterface $JWTManager
    ) {
        $user = new User('admin', 'test');
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }
}
