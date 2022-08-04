<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\Comment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function getQueryBuilderByGame(string $slug): QueryBuilder
    {
        return $this->createQueryBuilder('comment')
            ->join('comment.game', 'game')
            ->where('game.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('comment.createdAt', 'DESC')
        ;
    }

}
