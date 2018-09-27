<?php

namespace App\Repository;

use App\Entity\Wwww;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Wwww|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wwww|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wwww[]    findAll()
 * @method Wwww[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WwwwRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Wwww::class);
    }

//    /**
//     * @return Wwww[] Returns an array of Wwww objects
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
    public function findOneBySomeField($value): ?Wwww
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
