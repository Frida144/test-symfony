<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path:'/', name:'app_home')]
    public function index(): Response 
    {
    $formations = [
    [
        'title' => 'Développement PHP',
        'description' => 'Découvrir le développement côté serveur.',
    ],
    [
        'title' => 'Symfony',
        'description' => 'Structurer une application web en PHP.',
    ],
    [
        'title' => 'JavaScript',
        'description' => 'Découvrir le développement côté client.',
    ],
    [
        'title' => 'React',
        'description' => 'Découvrir le framework JavaScript React.',
    ],
    [
        'title' => 'Node.js',
        'description' => 'Découvrir le runtime JavaScript côté serveur.',
    ],
];
    //return new Response('Bienvenue sur mon application Symfony');
        return $this->render('home/index.html.twig', [
            'formations' => $formations
        ]);
    }
}
