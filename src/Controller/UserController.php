<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\UserService;

class UserController extends AbstractController
{
    public function __construct(
        private UserService $userService
    ) {}

    #[Route(path:'/profil', name:'app_profile')]
    public function profile(): Response
{
    $users = $this->userService->getUsers();

    return $this->render('user/index.html.twig', [
        'users' => $users
    ]);
}
}
