<?php

namespace BPCI\SumUp\Tests\Repository;

use BPCI\SumUp\Tests\Entity\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AddressRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('a')
            ->where('a.something = :value')->setParameter('value', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
