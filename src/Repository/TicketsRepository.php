<?php

namespace App\Repository;

use App\Entity\Tickets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\User;

/**
 * @method Tickets|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tickets|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tickets[]    findAll()
 * @method Tickets[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tickets::class);
    }

    /**
     * @return Tickets[] Returns an array of Tickets objects
     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findOneBytickets($projectId): ?Array
    {
      $entityManager = $this->getEntityManager();
      $query = $entityManager->createQuery(
       "SELECT k,l.username,w.username
       FROM App\Entity\Tickets k
       JOIN App\Entity\User l
       WITH l.id = k.assigned_id
       JOIN App\Entity\User w
       WITH w.id = k.creater_id
       WHERE k.project_id = $projectId"
       );
       return $query->execute();
     }
}
