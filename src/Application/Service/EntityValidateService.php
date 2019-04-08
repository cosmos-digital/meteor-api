<?php
namespace App\Application\Service;

use App\Entity\IEntity;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityValidateService implements IEntityValidateService
{
    private $validator;
    private $jsonResponse;

    /**
     * __construct
     *
     * @param Symfony\Component\Validator\Validator\ValidatorInterface $validator
     *
     * @return void
     */
    public function __construct(
        ValidatorInterface $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * validate
     *
     * @param App\Entity\IEntity $entity
     *
     * @return void
     */
    public function validate(IEntity $entity): ?array
    {
        $validate_errors = $this->validator->validate($entity);

        $errors = [];
        if (count($validate_errors) > 0) {

            foreach ($validate_errors as $error) {
                array_push($errors, [
                    'message' => $error->getMessage(),
                    'property_path' => $error->getPropertyPath(),
                ]);
            }

        }
        return $errors;
    }
}
