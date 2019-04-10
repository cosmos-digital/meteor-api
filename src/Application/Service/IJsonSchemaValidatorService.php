<?php

namespace App\Application\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

interface IJsonSchemaValidatorService
{
    /**
     * __construct
     *
     * @param RequestStack $request
     * @param ParameterBagInterface $parameterBag
     * @param JsonResponse $jsonResponse
     *
     * @return void
     */
    public function __construct(RequestStack $request, ParameterBagInterface $params, JsonResponse $jsonResponse);

    /**
     * validate
     *
     * @return void
     */
    public function validate(): void;
}
