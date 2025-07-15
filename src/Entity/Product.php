<?php

namespace App\Entity;

use App\Message\ProductMessage;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/^\d+$/', message: 'Price must be a number.')]
    #[ORM\Column]
    private ?float $price = null;

    #[Assert\NotBlank]
    #[Assert\Url]
    #[ORM\Column(length: 255)]
    private ?string $imageUrl = null;

    #[Assert\NotBlank]
    #[Assert\Url]
    #[ORM\Column(length: 255)]
    private ?string $productUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getProductUrl(): ?string
    {
        return $this->productUrl;
    }

    public function setProductUrl(string $productUrl): static
    {
        $this->productUrl = $productUrl;

        return $this;
    }

    public static function fromMessage(ProductMessage $productMessage): array
    {
        return [
          'title' => $productMessage->title,
          'price' => $productMessage->price,
          'url' => $productMessage->url,
          'image' => $productMessage->image,
        ];
    }
}
