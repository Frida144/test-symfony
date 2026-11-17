<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route(path:'/profil/{name}', name:'app_profile', defaults: ['name' => 'inconnu'])]
    public function profile(string $name): Response
{
    $name = "alice";
    $age = 47;
    $city = "Toulouse";
    return $this->render('user/index.html.twig', [
        'name' => $name,
        'age' => $age,
        'city' => $city
    ]);
}
}