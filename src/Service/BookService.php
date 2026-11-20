<?php

namespace App\Service;

use App\Entity\Book;
use App\Repository\BookRepository;

class BookService
{
    public function __construct(
        private BookRepository $bookRepository
    ) {}

    public function getBooks(): array {
        return $this->bookRepository->findAll() ?? [];
    }
    public function getBookById(int $id): ?Book
    {
    return $this->bookRepository->find($id);
    }
    public function searchByTitle(string $title): array
    {
    return $this->bookRepository->findByTitle($title);
    }

      public function getBooksByTitle(string $title): array
    {
        return $this->bookRepository->findByTitle($title);
    }

    public function getBooksByAfterPublishAt(string $date): array
    {
        return $this
            ->bookRepository
            ->findPublishedAfter(
                new \DateTimeImmutable($date)
            );
    }

    public function getBooksByCategoryName(string $categoryName): array
    {
    return $this->bookRepository->findByCategory($categoryName);
    }

    public function getBooksByFilters(string $categoryId, string $date): array
    {
        $category = ctype_digit($categoryId) ? (int) $categoryId : null;
        $publishedAfter = \DateTimeImmutable::createFromFormat('!Y-m-d', $date) ?: null;

        return $this->bookRepository->findByFilters($category, $publishedAfter);
    }

}