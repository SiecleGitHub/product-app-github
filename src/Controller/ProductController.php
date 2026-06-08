<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            "product" => $product
        ]);
    }

    #[Route('/product/new', name: 'product_new', methods: ['GET', 'POST'])]
    public function new(Request $request,
                        EntityManagerInterface $manager): Response
    {
        $product = new Product;

        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($product);

            $manager->flush();

            $this->addFlash(
                'success',
                'Product created successfully'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId()
            ]);

        }

        return $this->render('product/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/product/{id<\d+>}/edit', name: 'product_edit',
            methods: ['GET', 'POST'])]
    public function edit(Product $product,
                         Request $request,
                         EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();

            $this->addFlash(
                'success',
                'Product updated successfully'
            );

            return $this->redirectToRoute('product_show', [
                'id' => $product->getId()
            ]);

        }

        return $this->render('product/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/product/{id<\d+>}/delete', name: 'product_delete',
            methods: ['GET', 'DELETE'])]
    public function delete(Product $product,
                           Request $request,
                           EntityManagerInterface $manager): Response
    {
        $form = $this->createFormBuilder()
                     ->setAction($this->generateUrl('product_delete', [
                        'id' => $product->getId()
                     ]))
                     ->setMethod('DELETE')
                     ->add('delete', SubmitType::class, [
                         'label' => 'Yes'
                     ])
                     ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->remove($product);

            $manager->flush();

            $this->addFlash('success', 'Product deleted successfully');

            return $this->redirectToRoute('product_index');

        }

        return $this->render('product/delete.html.twig', [
            'form' => $form
        ]);
    }
}
