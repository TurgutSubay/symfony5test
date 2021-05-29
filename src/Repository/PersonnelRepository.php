<?php

namespace App\Repository;

use App\Entity\Personnel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Personnel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personnel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personnel[]    findAll()
 * @method Personnel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personnel::class);
    }

    public function JoinOfficeDQL($id = 1)
    {
       $entityManager = $this->getEntityManager();
       $query = $entityManager->createQuery('SELECT p,o.name AS officeName FROM App\Entity\Personnel p JOIN p.office o WHERE p.id=1');
       return $query->getResult();
    }


    public function JoinOfficeQueryBuilder($id = 1)
    {
        $entityManager = $this->getEntityManager();
        $qb = $entityManager->createQueryBuilder();
        $qb->select('p,o.name AS officeName')
            ->from('App\Entity\Personnel', 'p')
            ->join('p.office','o',null,null)
            ->where('p.id > :id')
            ->orderBy('p.name', 'ASC')
            ->setParameter('id', 0);

        return $qb->getQuery()->getResult();
    }
//// Example - $qb->join('u.Group', 'g', 'WITH', 'u.status = ?1')
//   public function join($join, $alias, $conditionType = null, $condition = null, $indexBy = null);
    // /**
    //  * @return Personnel[] Returns an array of Personnel objects
    //  */
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
    public function findOneBySomeField($value): ?Personnel
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
