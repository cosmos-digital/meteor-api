<?php

namespace App\Application\Service;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class AuthenticateService implements IAuthenticateService
{
    private $token;
    private $JWTManager;

    /**
     * __construct
     *
     * @param JWTTokenManagerInterface $JWTManager
     *
     * @return void
     */
    public function __construct(JWTTokenManagerInterface $JWTManager)
    {
        $this->JWTManager = $JWTManager;
    }

    /**
     * authenticate
     *
     * @param App\Entity\User mixed $user
     *
     * @return IAuthenticateService
     */
    public function authenticate(User $user): IAuthenticateService
    {
        $this->user = $user;
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
