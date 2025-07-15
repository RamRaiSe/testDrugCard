<?php

namespace App\Service;

use App\Message\ProductMessage;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ProductParser
{
    #[Required]
    public MessageBusInterface $messageBus;
    #[Required]
    public ValidatorInterface $validator;

    public function parse(string $html): void
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        $itemBlocks = $xpath->query('//div[contains(@class, "product-thumb")]');

        foreach ($itemBlocks as $itemBlock) {
            $title = $xpath->evaluate('string(.//div[contains(@class, "caption")]//a)', $itemBlock);
            $price = $xpath->evaluate('string(.//*[contains(@class, "price")]//span[@class="pice-new"])', $itemBlock);

            if (!$price) {
                $price = $xpath->evaluate('string(.//*[contains(@class, "price")])', $itemBlock);
            }

            $link = $xpath->evaluate('string(.//div[contains(@class, "caption")]//a/@href)', $itemBlock);
            $img = $xpath->evaluate('string(.//div[@class="image"]//a//img/@src)', $itemBlock);

            $title = trim($title);
            $price = (int)explode(' ', trim($price))[0];
            $url = trim($link);
            $image = trim($img);

            if (!$this->validateProductData($title, $price, $url, $image)) {
                continue;
            }

            $this->messageBus->dispatch(new ProductMessage($title, $price, $image, $url));
        }
    }

    private function validateProductData($title, $price, $image, $url): bool
    {
        if (empty($title) || !is_numeric($price) || !filter_var($url, FILTER_VALIDATE_URL) || !filter_var($image, FILTER_VALIDATE_URL)) {
            return false;
        }

        return true;
    }
}
