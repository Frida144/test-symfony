<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\CategoryService;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Category;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

class CategoryController extends AbstractController
{
    public function __construct(
        private CategoryService $categoryService,
        private EntityManagerInterface $entityManager
    )  {}

    #[Route(path:'/categories', name: 'app_categories')]
    #[IsGranted('IS_AUTHENTICATED_FULLY', message: 'Vous devez être connecté pour accéder à cette page.')]
    public function showAllCategories(): Response
    {
        //Récupération de toutes les catégories de la BDD
        $categories = $this->categoryService->getCategories();

        $categoryData = [];
        foreach ($categories as $category) {
            $categoryData[] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }

        return $this->render('category/show_all_categories.html.twig',[
            'categories' => $categories,
            'categoryData' => $categoryData
        ]);
    }

    #[Route(path:'/category/new', name:'app_category_new', methods:["GET", "POST"])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous devez être administrateur pour accéder à cette page.')]
    public function new(Request $request):Response 
    {
        $category = new Category();

        $form = $this->createForm('App\\Form\\CategoryType', $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
            $msg = 'Catégorie enregistrée avec succès.';

            $this->addFlash('notice', $msg);

            return $this->redirectToRoute('app_category_new');
        }

        return $this->render('category/category_new.html.twig', [
            'form'=> $form
        ]);
    }
}