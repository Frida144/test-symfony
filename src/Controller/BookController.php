<?php

namespace App\Controller;

use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class BookController extends AbstractController
{
    public function __construct(
        private BookService $bookService
    )  {}

    #[Route('/livres', name: 'app_books')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $this->bookService->getBooks(),
        ]);
    }
    #[Route('/livre/{id}', name: 'app_book_show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $book = $this->bookService->getBookById($id);
        if (!$book) {
            throw $this->createNotFoundException('Livre non trouvé');
        }
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/books/search', name: 'app_book_search', methods: ['GET'])]
    public function search(#[MapQueryParameter] string $title = ''): Response
    {

     $books = $this->bookService->searchByTitle($title);

        return $this->render('book/search.html.twig', [
            'books' => $books,
            'title' => $title,
        ]);
    }
}