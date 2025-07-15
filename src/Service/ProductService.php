<?php

namespace App\Service;

class ProductService
{
    private string $filePath;

    public function __construct(string $filePath = null)
    {
        $this->filePath = $filePath ?? __DIR__ . '/../../../resource/products.csv';
    }

    public function writeToCsv(array $data): void
    {
        $isNew = !file_exists($this->filePath);

        $handle = fopen($this->filePath, 'ab');

        if ($handle === false) {
            throw new \RuntimeException('Class: ' . __CLASS__ . '; Method: ' . __METHOD__ . '; Could not open file: ' . $this->filePath);
        }

        if ($isNew) {
            fputcsv($handle, array_keys($data));
        }

        fputcsv($handle, array_values($data));

        fclose($handle);
    }
}
