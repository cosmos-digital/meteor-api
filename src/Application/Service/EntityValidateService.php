<?php
namespace App\Application\Service;

use App\Entity\IEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityValidateService implements IEntityValidateService
{
    private $validator;
    private $jsonResponse;

    /**
     * __construct
     *
     * @param Symfony\Component\HttpFoundation\JsonResponse $jsonResponse
     * @param Symfony\Component\Validator\Validator\ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(
        JsonResponse $jsonResponse,
        ValidatorInterface $validator
    ) {

        $this->jsonResponse = $jsonResponse;
        $this->validator = $validator;
    }

    /**
     * validate
     *
     * @param App\Entity\IEntity $entity
     *
     * @return void
     */
    public function validate(IEntity $entity): void
    {
        $validate_errors = $this->validator->validate($entity);

        if (count($validate_errors) > 0) {

            $errors = [];

            foreach ($validate_errors as $error) {
                array_push($errors, [
                    'message' => $error->getMessage(),
                    'property_path' => $error->getPropertyPath(),
                ]);
            }

            $this->jsonResponse
                ->setData($errors)
                ->setStatusCode($this->jsonResponse::HTTP_BAD_REQUEST);

            throw new \InvalidArgumentException();
        }
    }
}
