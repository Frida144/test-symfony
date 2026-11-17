<?php

namespace App\Controller;

use App\Service\BookService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
}