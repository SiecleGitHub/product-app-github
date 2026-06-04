<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index', methods: ['GET', 'HEAD'])]
    public function index(ProductRepository $repository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $repository->findAll()
        ]);
    }

    #[Route('/product/{id<\d+>}', name: 'product_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        dd($id);
    }
}
