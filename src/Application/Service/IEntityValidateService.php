<?php

namespace App\Application\Service;

use App\Entity\IEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface IEntityValidateService
{

    /**
     * __construct
     *
     * @param Symfony\Component\HttpFoundation\JsonResponse $jsonResponse
     * @param Symfony\Component\Validator\Validator\ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(JsonResponse $jsonResponse, ValidatorInterface $validator);
    /**
     * validate
     *
     * @param App\Entity\IEntity $entity
     *
     * @return void
     */
    public function validate(IEntity $entity): void;
}
