<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
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
        // SELECT * FROM game AS game
        return $this->createQueryBuilder('game')
            ->select('game', 'genres', 'publisher', 'countries', 'comments')
            // JOIN genres ON genres.id = game.genre_id
            ->join('game.genres', 'genres')
            ->join('game.publisher', 'publisher')
            ->join('game.countries', 'countries')
            ->leftJoin('game.comments', 'comments')
            // WHERE game.slug = ?
            // toujours mettre les ":" devant le nom de votre alias
            ->where('game.slug = :slug')
            // Pour chaque alias déclaré, vous avez un setParameter
            // Le premier paramètre est l'alias et le deuxième la valeur
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getResult()
        ;
    }
}
