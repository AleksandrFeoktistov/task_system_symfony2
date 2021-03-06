<?php

namespace App\Repository;

use App\Entity\Tags;
use App\Entity\TicketsTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\ORM\Query;

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
     * @param $ticketId
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
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
        "SELECT l.name, l.id
         FROM App\Entity\TicketsTags k
         JOIN App\Entity\Tags l
         WITH k.tag_id = l.id
         WHERE k.ticket_id = $ticketId"
       );

   // returns an array of Product objects
        return $query->execute();





    }

}
