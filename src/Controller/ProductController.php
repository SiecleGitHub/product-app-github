<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    //public function show(int $id, ProductRepository $repository): Response
    public function show(Product $product): Response
    {
        /*
        $product = $repository
            ->createQueryBuilder('p')
            ->where("p.id = :id")
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
        */
        // $product = $repository->findOneBy(['id' => $id]);
        // $product = $repository->find($id);

        // if ($product === null) {
        //     throw $this->createNotFoundException('Product not found');
        // }

        return $this->render('product/show.html.twig', [
            "product" => $product
        ]);
    }

    #[Route('/product/new', name: 'product_new', methods: ['GET'])]
    public function new(): Response
    {
        $form = $this->createForm(ProductType::class);

        return $this->render('product/new.html.twig', [
            'form' => $form
        ]);
    }
}
