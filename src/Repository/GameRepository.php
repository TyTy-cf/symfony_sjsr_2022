<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends AbstractVapeurIshRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function findBySlugRelations(string $slug): ?Game
    {
        return $this->createQueryBuilder('game')
            ->select('game', 'genres', 'publisher', 'countries')
            ->join('game.genres', 'genres')
            ->join('game.countries', 'countries')
            ->leftJoin('game.publisher', 'publisher')
            ->where('game.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    function getGroupedByGameByOrder(string $orderBy = 'SUM(library.gameTime)', int $limit = 9): array {
        $qb = $this->createQueryBuilder('game')
            ->leftJoin(Library::class, 'library', Join::WITH, 'library.game = game')
            ->groupBy('game')
            ->orderBy($orderBy, 'DESC');

        if ($limit !== null) {
            $qb->setMaxResults($limit);
        }

        return $qb->getQuery()
            ->getResult()
        ;
    }

    public function getQbAll(): QueryBuilder
    {
        $qb = parent::getQbAll();
        return $qb->select('game', 'publisher')
            ->leftJoin('game.publisher', 'publisher')
        ;
    }
}
