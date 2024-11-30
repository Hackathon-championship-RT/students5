<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\TileType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TileTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TileType::class);
    }

    public function findByCategory(string $category): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.category = :category')
            ->setParameter('category', $category)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findOneByName(string $name): ?TileType
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByCountry(string $country): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.country = :country')
            ->setParameter('country', $country)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
