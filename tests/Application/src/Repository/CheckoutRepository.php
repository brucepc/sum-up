<?php

namespace BPCI\SumUp\Tests\Repository;

use BPCI\SumUp\Tests\Entity\Checkout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CheckoutRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Checkout::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
