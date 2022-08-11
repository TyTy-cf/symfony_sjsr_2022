<?php

namespace App\Repository;

use App\Entity\Library;
use App\Entity\Publisher;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publisher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publisher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publisher[]    findAll()
 * @method Publisher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublisherRepository extends AbstractVapeurIshRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publisher::class);
    }

    public function getQbAll(): QueryBuilder
    {
        $qb = parent::getQbAll();
        return $qb->select('publisher', 'country')
            ->leftJoin('publisher.country', 'country')
        ;
    }

    public function getPublisherTurnover(): array
    {
        $qb = parent::getQbAll();
        return $qb->select('publisher', 'SUM(games.price)')
            ->join('publisher.games', 'games')
            ->join(Library::class, 'library', Join::WITH, 'library.game = games')
            ->groupBy('publisher')
            ->getQuery()
            ->getResult()
        ;
    }
}
