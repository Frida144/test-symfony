<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BookController extends AbstractController
{
    private array $books = [
        ['id' => 1, 'title' => 'Dune', 'author' => 'Frank Herbert'],
        ['id' => 2, 'title' => '1984', 'author' => 'George Orwell'],
        ['id' => 3, 'title' => 'Fondation', 'author' => 'Isaac Asimov'],
    ];

    #[Route('/livres', name: 'app_books')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $this->books,
        ]);
    }
    #[Route('/livre/{id}', name: 'app_book_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $book = $this->books[$id - 1] ?? null;
        if (!$book) {
            throw $this->createNotFoundException('Livre non trouvé');
        }
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
}
