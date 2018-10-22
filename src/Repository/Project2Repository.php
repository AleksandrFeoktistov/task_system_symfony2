<?php

namespace App\Repository;

use App\Entity\Project2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Project2|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project2|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project2[]    findAll()
 * @method Project2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Project2Repository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Project2::class);
    }

//    /**
//     * @return Project2[] Returns an array of Project2 objects
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
    public function findOneBySomeField($value): ?Project2
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
