<?php

namespace App\Repository;

use App\Entity\Suppliers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Suppliers>
 *
 * @method Suppliers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Suppliers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Suppliers[]    findAll()
 * @method Suppliers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuppliersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suppliers::class);
    }

    /**
     * @param string $filter
     * @return Suppliers[] Returns an array of Suppliers objects
     */
    public function findByFilteredSuppliers(string $filter): array
    {
        return $this->createQueryBuilder('s')
            ->where('s.name LIKE :filter')
            ->setParameter('filter', '%' . $filter . '%')
            ->getQuery()
            ->getResult();
    }







//    /**
//     * @return Suppliers[] Returns an array of Suppliers objects
//     */
//    public function findByFilteredSuppliers($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Suppliers
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
