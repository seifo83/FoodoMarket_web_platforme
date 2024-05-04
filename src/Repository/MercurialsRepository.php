<?php

namespace App\Repository;

use App\Entity\Mercurials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Mercurials>
 *
 * @method Mercurials|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mercurials|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mercurials[]    findAll()
 * @method Mercurials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MercurialsRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     * @codeCoverageIgnore
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mercurials::class);
    }

//    /**
//     * @return Mercurials[] Returns an array of Mercurials objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Mercurials
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
