<?php

namespace App\Application\Service;

use App\Entity\User;
use App\Infrastructure\Repository\IUserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;

final class AccountCreateService implements IAccountCreateService
{
    private $userRepository;
    private $validator;
    private $jsonResponse;

    /**
     * __construct
     *
     * @param App\Application\Service\IEntityValidateService $validator
     * @param App\Infrastructure\Repository\IUserRepository $userRepository
     * @param Symfony\Component\HttpFoundation\JsonResponse $jsonResponse
     *
     * @return void
     */
    public function __construct(
        IEntityValidateService $validator,
        IUserRepository $userRepository,
        JsonResponse $jsonResponse
    ) {
        $this->validator = $validator;
        $this->userRepository = $userRepository;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * create
     *
     * @param App\Entity\User $user
     *
     * @return void
     */
    public function create(User $user): void
    {
        $errors = $this->validator->validate($user);

        if (!empty($errors)) {

            $this->jsonResponse
                ->setData($errors)
                ->setStatusCode($this->jsonResponse::HTTP_BAD_REQUEST);

            throw new \InvalidArgumentException();
        }

        $this->userRepository->save($user);

        $this->jsonResponse
            ->setData(['id' => $user->getId()])
            ->setStatusCode($this->jsonResponse::HTTP_CREATED);
    }
}
