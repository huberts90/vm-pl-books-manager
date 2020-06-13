<?php

namespace App\Repository;

use App\Domain\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Book|null find($id, $lockMode = null, $lockVersion = null)
 * @method Book|null findOneBy(array $criteria, array $orderBy = null)
 * @method Book[]    findAll()
 * @method Book[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRepository extends ServiceEntityRepository
{
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, Book::class);
    }

    public function findOneById(int $id): ?object
    {
        return $this->entityManager
            ->getRepository(Book::class)
            ->find($id);

    }

    public function create(Book $book): Book
    {
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }

    public function update(Book $book): Book
    {
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }

    public function delete(Book $book): void
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();

    }
}
