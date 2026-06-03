<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index', methods:['GET', 'HEAD'])]
    public function index(): Response
    {
        $products = [
            ['id' => 1, 'name' => 'Product 1', 'price' => 10.99],
            ['id' => 2, 'name' => 'Product 2', 'price' => 19.99],
            ['id' => 3, 'name' => 'Product 3', 'price' => 5.99],
        ];
        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }
}
