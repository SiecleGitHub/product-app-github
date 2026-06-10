<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/products', format: 'json')]
final class ProductController extends AbstractController
{
    #[Route('', methods: ['GET'], name: 'app_api_products')]
    public function index(ProductRepository $repository): JsonResponse
    {
        return $this->json(
            $repository->findAll(),
            context: ['groups' => ['api-product-index']]
        );
    }

    #[Route("/{id}", methods: ['GET'])]
    public function show(Product $product,
                         SerializerInterface $serializer): JsonResponse
    {
        $json_data = $serializer->serialize(
            $product,
            'json',
            ['groups' => ['api-product-detail']]
        );

        return new JsonResponse($json_data, json: true);
    }

    #[Route("", methods: ['POST'])]
    public function create(
        #[MapRequestPayload] Product $product,
        EntityManagerInterface $manager
    ): JsonResponse
    {
        $manager->persist($product);
        $manager->flush();

        return $this->json($product, Response::HTTP_CREATED);
    }

    #[Route("/{id}", methods: ['PATCH'])]
    public function update(
        Product $product,
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $manager
    ): JsonResponse
    {
        $serializer->deserialize(
            $request->getContent(),
            Product::class,
            'json',
            ['object_to_populate' => $product]
        );

        $errors = $validator->validate($product);

        if ($errors->count() > 0) {
            return $this->json(
                $errors,
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $manager->flush();

        return $this->json($product);
    }

    #[Route("/{id}", methods: ["DELETE"])]
    public function delete(
        Product $product,
        EntityManagerInterface $manager
    ): JsonResponse
    {
        $manager->remove($product);

        $manager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
