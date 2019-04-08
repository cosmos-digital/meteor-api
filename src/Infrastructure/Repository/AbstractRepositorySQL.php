<?php

namespace App\Infrastructure\Repository;

use App\Entity\IEntity;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractRepositorySQL
{
    protected $objectClass;

    protected $instance;
    /**
     * @var EntityManagerInterface
     */

    protected $entityManager;

    /**
     * @var ObjectRepository
     */
    private static $objectRepository;

    public function __construct()
    {

        if (empty($this->objectClass)) {
            throw new \LogicException(
                sprintf('protected var $objectClass not set in %s',
                    \get_class($this)
                )
            );
        }
        $this->objectRepository = $this->entityManager->getRepository($this->objectClass);
    }

    /**
     * isValideEntity
     *
     * @param IEntity $entity
     *
     * @return void
     */
    private function isValideEntity(IEntity $entity): void
    {
        if ($this->objectClass !== \get_class($entity)) {

            throw new \LogicException(
                sprintf(
                    'Object %s is different of class %s defined on repository %s',
                    \get_class($entity), $this->objectClass, \get_class($this)
                ), 500);
        }
    }

    protected function getInstance(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param string $uid
     * @return IEntity
     */
    public function findById(string $uid): ?IEntity
    {
        return $this->objectRepository->find($uid);
    }
    /**
     * @return array
     */
    public function findAll(): array
    {
        return $this->objectRepository->findAll();
    }
    /**
     * @param IEntity $entity
     */
    public function save(IEntity $entity): void
    {
        $this->isValideEntity($entity);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
    /**
     * @param IEntity $entity
     */
    public function delete(IEntity $entity): void
    {
        $this->isValideEntity($entity);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
