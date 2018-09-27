<?php

namespace App\Repository;

use App\Entity\Proj;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Proj|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proj|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proj[]    findAll()
 * @method Proj[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Proj::class);
    }

//    /**
//     * @return Proj[] Returns an array of Proj objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Proj
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
