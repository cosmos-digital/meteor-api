<?php
namespace App\Application\Service;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

interface IAuthenticateService
{
    /**
     * __construct
     *
     * @param JWTTokenManagerInterface $JWTManager
     *
     * @return void
     */
    public function __construct(JWTTokenManagerInterface $JWTManager);
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
