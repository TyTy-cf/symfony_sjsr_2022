<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractVapeurIshRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry, string $entity)
    {
        parent::__construct($registry, $entity);
    }

    public function getQbAll(): QueryBuilder {
        $entityName = explode('\\', $this->_entityName)[2];
        return $this->createQueryBuilder(strtolower($entityName));
    }

}