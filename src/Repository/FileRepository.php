<?php

namespace App\Repository;

use App\Entity\File;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Array_;

/**
 * @method File|null find($id, $lockMode = null, $lockVersion = null)
 * @method File|null findOneBy(array $criteria, array $orderBy = null)
 * @method File[]    findAll()
 * @method File[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method File[]    findByName()
 */
class FileRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, File::class);
    }

//     /**
//      * @return File[] Returns an array of File objects
//      */
//    public function findByName($owner)
//    {
//        return $this->createQueryBuilder('file')
//            ->andWhere('file.owner = :val')
//            ->setParameter('val', $owner)
//            ->orderBy('file.name', 'ASC')
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?File
//    {
//        return $this->createQueryBuilder('file')
//            ->andWhere('file.name = python')
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



}
