<?php

namespace App\Repository;

use App\Entity\Tags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Tickets;
use App\Entity\TicketsTags;

/**
 * @method Tags|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tags|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tags[]    findAll()
 * @method Tags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Tags::class);
    }

    /**
     * @return Tags[] Returns an array of Tags objects
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
     public function findBySomeField($ticketId)
    {
        // return $this->createQueryBuilder('t')
        //     ->andWhere('t.exampleField = :val')
        //     ->setParameter('val', $value)
        //     ->getQuery()
        //     ->getOneOrNullResult()
        // ;
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
         "SELECT l.name, l.id
         FROM App\Entity\TicketsTags k
         JOIN App\Entity\Tags l
         WITH k.tag_id = l.id
         WHERE k.ticket_id = $ticketId"
         );
         return $query->execute();
    }
    public function findByTags($tag)
   {
       // return $this->createQueryBuilder('t')
       //     ->andWhere('t.exampleField = :val')
       //     ->setParameter('val', $value)
       //     ->getQuery()
       //     ->getOneOrNullResult()
       // ;
       $entityManager = $this->getEntityManager();
       $query = $entityManager->createQuery(
        "SELECT e
        FROM App\Entity\Tags k
        JOIN App\Entity\TicketsTags l
        WITH l.tag_id = k.id
        JOIN App\Entity\Tickets e
        WITH e.id = l.ticket_id
        WHERE k.id = $tag"
        );
        return $query->execute();
   }
}
