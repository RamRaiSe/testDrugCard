<?php

namespace App\Tests\Service;

use App\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{
    public function testWriteToCsv()
    {
        $testFilePath = __DIR__ . '/../../resource/test_products.csv';

        if (file_exists($testFilePath)) {
            unlink($testFilePath);
        }

        $service = new ProductService($testFilePath);

        $data = [
            'title' => 'Test Product',
            'price' => 123,
            'image' => 'image.jpg',
            'url' => 'https://test.com'
        ];

        $service->writeToCsv($data);

        $this->assertFileExists($testFilePath);

        $contents = file($testFilePath);
        $this->assertGreaterThan(1, count($contents));
    }
}
