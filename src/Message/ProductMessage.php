<?php

namespace App\Message;

class ProductMessage
{
    public function __construct(
        public string $title,
        public float $price,
        public string $image,
        public string $url
    ) {}
}
