<?php

namespace App\Application\Service;

use Opis\JsonSchema\Schema;
use Opis\JsonSchema\Validator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

final class JsonSchemaValidatorService implements IJsonSchemaValidatorService
{
    private $params;
    private $request;
    private $jsonResponse;

    /**
     * __construct
     *
     * @param RequestStack $request
     * @param ParameterBagInterface $parameterBag
     * @param JsonResponse $jsonResponse
     *
     * @return void
     */
    public function __construct(RequestStack $request, ParameterBagInterface $params, JsonResponse $jsonResponse)
    {
        $this->request = $request;
        $this->params = $params;
        $this->jsonResponse = $jsonResponse;
    }

    /**
     * validate
     *
     * @param \stdClass $data
     *
     * @return void
     */
    public function validate(): void
    {
        $path = $this->params->get('path_json_schema_validator');
        $schema = $this->request->getCurrentRequest()->get('_route');

        $data = json_decode($this->request->getCurrentRequest()->getContent());

        $schemaFile = file_get_contents("$path/$schema.json");
        $schemaJson = Schema::fromJsonString($schemaFile);
        $validator = new Validator();

        $result = $validator->schemaValidation($data, $schemaJson);

        if (!$result->isValid()) {
            $error = $result->getFirstError();
            $data = [
                'error' => $error->keywordArgs(),
            ];
            $this->jsonResponse->setData($data)
                ->setStatusCode(
                    $this->jsonResponse::HTTP_BAD_REQUEST
                );
            throw new \InvalidArgumentException();
        }
    }
}
