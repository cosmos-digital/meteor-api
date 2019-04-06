<?php
namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

interface IAuthenticateService
{
    /**
     * __construct
     *
     * @param JWTTokenManagerInterface $JWTManager
     * @param IUserRepository $userRepository
     * @param JsonResponse $jsonResponse
     * @return void
     */
    public function __construct(JWTTokenManagerInterface $JWTManager, IUserRepository $userRepository, JsonResponse $jsonResponse);
    /**
     * authenticate
     *
     * @param App\Entity\User $user
     *
     * @return IAuthenticateService
     */
    public function authenticate(User $user): IAuthenticateService;

    /**
     * getToken
     *
     * @return string
     */
    public function getToken(): ?string;

    /**
     * getUser
     *
     * @return User
     */
    public function getUser(): ?User;
}
