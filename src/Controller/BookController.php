<?php

namespace App\Controller;

use App\Service\BookService;
use App\Service\CategoryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class BookController extends AbstractController
{
    public function __construct(
        private BookService $bookService
    )  {}

    #[Route(path: '/books', name: 'app_books')]
    public function index(
        CategoryService $categoryService,
        #[MapQueryParameter] string $category = '',
        #[MapQueryParameter] string $date = '',
    ): Response {
        return $this->render('book/index.html.twig', [
            'books' => $this->bookService->getBooksByFilters($category, $date),
            'categories' => $categoryService->getCategories(),
            'selectedCategory' => $category,
            'selectedDate' => $date,
        ]);
    }

    #[Route('/books/{id}', name: 'app_book_show', requirements: ['id' => '\d+'])]
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

    #[Route(path: '/books/recent/{date}', name: 'app_book_recent', requirements: ['date' => '\d{4}-\d{2}-\d{2}'])]
    public function showBooksByAfterPublishAt(string $date): Response 
    {
        $books = $this->bookService->getBooksByAfterPublishAt($date);
        
        return $this->render('book/index.html.twig', [
            'books' => $books
        ]);
    }

    #[Route(path: '/books/category/{categoryName}', name: 'app_book_category')]
    public function findByCategory(string $categoryName): Response
    {
        $books = $this->bookService->getBooksByCategoryName($categoryName);

        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }
}