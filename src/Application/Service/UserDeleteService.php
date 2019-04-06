<?php

namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class UserDeleteService implements IUserDeleteService
{
    private $userRepository;
    private $jsonResponse;
    /**
     * __construct
     *
     * @param App\Infrastructure\Repository\IUserRepository $userRepository
     * @param Symfony\Component\HttpFoundation\JsonResponse $jsonResponse
     * @return void
     */
    public function __construct(
        IUserRepository $userRepository,
        JsonResponse $jsonResponse
    ) {
        $this->userRepository = $userRepository;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * deleteByUid
     *
     * @param string $uid
     *
     * @return void
     */
    public function deleteByUid(string $uid): void
    {
        $user = $this->userRepository->findById(
            $uid
        );

        if (!isset($user)) {

            $this->jsonResponse
                ->setData([
                    'message' => 'User not found',
                    'property_path' => 'user_not_found',
                ])
                ->setStatusCode(
                    $this->jsonResponse::HTTP_BAD_REQUEST
                );

            throw new \InvalidArgumentException();
        }

        $this->userRepository->delete($user);

        $this->jsonResponse->setStatusCode(
            $this->jsonResponse::HTTP_NO_CONTENT
        );
    }
}
