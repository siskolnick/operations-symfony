<?php

namespace App\Repository;

use App\Entity\OperationResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OperationResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperationResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperationResult[]    findAll()
 * @method OperationResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OperationResult::class);
    }

    /**
     * @return OperationResult[] Returns an array of OperationResult objects
     */
    public function findAll()
    {
        return $this->createQueryBuilder('o')
            ->orderBy('o.id', 'DESC')
            //->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?OperationResult
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
