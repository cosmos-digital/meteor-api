<?php

namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthenticateService implements IAuthenticateService
{
    private $user;
    private $token;
    private $JWTManager;
    private $userRepository;

    /**
     * __construct
     *
     * @param JWTTokenManagerInterface $JWTManager
     * @param IUserRepository $userRepository
     * @param JsonResponse $jsonResponse
     * @return void
     */
    public function __construct(
        JWTTokenManagerInterface $JWTManager,
        IUserRepository $userRepository,
        JsonResponse $jsonResponse
    ) {
        $this->JWTManager = $JWTManager;
        $this->userRepository = $userRepository;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * authenticate
     *
     * @param string $username
     * @param string $password
     *
     * @return IAuthenticateService
     */
    public function authenticate(string $username, string $password): IAuthenticateService
    {
        $this->user = $this->userRepository
            ->findUserByUsername(
                $username
            );

        if (!isset($this->user)) {

            $this->jsonResponse
                ->setData([
                    'message' => 'User not found',
                    'property_path' => 'user_not_found',
                ])
                ->setStatusCode($this->jsonResponse::HTTP_BAD_REQUEST);

            throw new \InvalidArgumentException();

        } elseif (!\password_verify($password, $this->user->getPassword())) {

            $this->jsonResponse
                ->setData([
                    'message' => 'Password Invalid',
                    'property_path' => 'password_invalid',
                ])
                ->setStatusCode($this->jsonResponse::HTTP_BAD_REQUEST);

            throw new \InvalidArgumentException();
        }

        $this->token = $this->JWTManager->create($this->user);

        return $this;
    }

    /**
     * getToken
     *
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * getUser
     *
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
}
