<?php

namespace App\Repository;

use App\Entity\Ww;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Ww|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ww|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ww[]    findAll()
 * @method Ww[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WwRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ww::class);
    }

//    /**
//     * @return Ww[] Returns an array of Ww objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ww
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
