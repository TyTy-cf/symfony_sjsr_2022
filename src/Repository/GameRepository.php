<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Library;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    /**
     */
    public function findBySlugRelations(string $slug)
    {
        return $this->createQueryBuilder('game')
            ->select('game', 'genres', 'publisher', 'countries', 'comments')
            ->join('game.genres', 'genres')
            ->join('game.countries', 'countries')
            ->leftJoin('game.comments', 'comments')
            ->leftJoin('game.publisher', 'publisher')
            ->where('game.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getResult()
        ;
    }

    function getGroupedByGameByOrder($orderBy = 'SUM(library.gameTime)', $limit = 9): array {
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

}
