<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart', methods:['GET'])]
    public function index(): Response
    {
        return $this->render('pages/cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
