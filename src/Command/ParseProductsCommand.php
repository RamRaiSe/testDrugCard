<?php

namespace App\Command;

use App\Service\ProductFetcher;
use App\Service\ProductParser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand('app:parse-products')]
class ParseProductsCommand extends Command
{
    #[Required]
    public EntityManagerInterface $entityManager;
    #[Required]
    public ProductParser $productParser;
    #[Required]
    public ProductFetcher $productFetcher;

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $urls = [
            'https://giulia.com.ua/odyag-dlya-domu-ta-snu/svitshoti/',
            'https://giulia.com.ua/odyag-dlya-domu-ta-snu/svitshoti/?page=2',
            'https://giulia.com.ua/odyag-dlya-domu-ta-snu/svitshoti/?page=3',
        ];

        foreach ($urls as $url) {
            $html = $this->productFetcher->fetch($url);
            $this->productParser->parse($html);
        }

        return Command::SUCCESS;
    }
}
