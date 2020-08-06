<?php

namespace App\Repository;

use App\Entity\Truc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class TrucRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Truc::class);
    }

    public function searchWhereIdGreaterThan($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id > :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

}
