<?php

namespace App\MessageHandler;

use App\Entity\Product;
use App\Message\ProductMessage;
use App\Service\ProductService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Service\Attribute\Required;

#[AsMessageHandler]
class ProductMessageHandler
{
    #[Required]
    public EntityManagerInterface $entityManager;
    #[Required]
    public ProductService $productService;

    public function __invoke(ProductMessage $message): void
    {
        $product = Product::fromMessage($message);

        $this->productService->writeToCsv($product);

        $product = new Product();
        $product->setName($message->title);
        $product->setPrice($message->price);
        $product->setProductUrl($message->url);
        $product->setImageUrl($message->image);

        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }
}
