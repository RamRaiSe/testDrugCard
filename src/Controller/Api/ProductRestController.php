<?php

namespace App\Controller\Api;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Service\Attribute\Required;

class ProductRestController extends AbstractController
{
    #[Required]
    public EntityManagerInterface $entityManager;

    #[Route('/products', name: 'api_products', methods: ['GET'])]
    public function getProducts(): JsonResponse
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $data = array_map(static function ($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'url' => $product->getProductUrl(),
                'image' => $product->getImageUrl(),
            ];
        }, $products);

        return new JsonResponse(json_encode($data, JSON_UNESCAPED_UNICODE), Response::HTTP_OK, [], true);
    }
}
