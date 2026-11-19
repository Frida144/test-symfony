<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

//    /**
//     * @return Book[] Returns an array of Book objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Book
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
     public function findByTitle(string $title): array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.title LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->orderBy('b.title')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPublishedAfter(\DateTimeInterface $date): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.publishAt  >= :date')
            ->setParameter('date', $date)
            ->orderBy('b.publishAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByCategory(string $categoryName): array
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.category', 'c')
            ->where('c.name = :categoryName')
            ->setParameter('category', $categoryName)
            ->orderBy('b.id')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByFilters(?int $categoryId, ?\DateTimeImmutable $publishedAfter): array
    {
        $qb = $this->createQueryBuilder('b')
            ->orderBy('b.publishAt', 'DESC');

        if ($categoryId !== null) {
            $qb->innerJoin('b.categories', 'c')
                ->andWhere('c.id = :categoryId')
                ->setParameter('categoryId', $categoryId);
        }

        if ($publishedAfter !== null) {
            $qb->andWhere('b.publishAt >= :date')
                ->setParameter('date', $publishedAfter);
        }

        return $qb->getQuery()->getResult();
    }
}
