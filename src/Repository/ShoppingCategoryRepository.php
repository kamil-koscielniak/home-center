<?php

namespace App\Repository;

use App\Entity\ShoppingCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ShoppingCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingCategory[]    findAll()
 * @method ShoppingCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShoppingCategory::class);
    }
}
