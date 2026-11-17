<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CalcController extends AbstractController
{
    #[Route('/calc/{number1}/{number2}/{operation}', name: 'app_calc')]
    public function calculatrice(int $number1, int $number2, string $operation): Response
    {
        if ($operation === 'add') {
            $result = $number1 + $number2;
        } elseif ($operation === 'sous') {
            $result = $number1 - $number2;
        } elseif ($operation === 'mult') {
            $result = $number1 * $number2;
        } elseif ($operation === 'div') {
            $result = $number1 / $number2;
        } else {
            $result = 'Opération non valide';
        }

        return $this->render('calc/index.html.twig', [
            'number1' => $number1,
            'number2' => $number2,
            'operation' => $operation,
            'result' => $result,
        ]);
    }
}
