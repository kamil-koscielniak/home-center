<?php

namespace App\Repository;

use App\Entity\ShoppingItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ShoppingItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShoppingItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShoppingItem[]    findAll()
 * @method ShoppingItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoppingItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ShoppingItem::class);
    }
}
