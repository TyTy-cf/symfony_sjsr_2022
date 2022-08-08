<?php

namespace App\Repository;

use App\Entity\Account;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends AbstractVapeurIshRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getAccountBySlug(string $slug): ?Account
    {
        return $this->createQueryBuilder('account')
            ->select('account', 'libraries', 'game', 'comments', 'country', 'comments_game')
            ->leftJoin('account.libraries', 'libraries')
            ->leftJoin('libraries.game', 'game')
            ->leftJoin('account.country', 'country')
            ->leftJoin('account.comments', 'comments')
            ->leftJoin('comments.game', 'comments_game')
            ->where('account.slug = :slug')
            ->setParameter('slug', $slug)
            ->orderBy('comments.createdAt', 'DESC')
            ->addOrderBy('libraries.installed', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function getQbAll(): QueryBuilder
    {
        $qb = parent::getQbAll();
        return $qb->select('account', 'country', 'COUNT(libraries) AS nbGames')
            ->leftJoin('account.libraries', 'libraries')
            ->leftJoin('account.country', 'country')
            ->groupBy('account')
        ;
    }
}
