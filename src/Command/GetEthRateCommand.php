<?php

namespace App\Command;

use App\Entity\Eth;
use App\Repository\EthRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsCommand(
    name: 'app:get-eth-rate',
    description: 'Add a short description for your command',
)]
class GetEthRateCommand extends Command
{

    public function __construct(private HttpClientInterface $httpClient ,
    private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {


    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->httpClient->request("GET" , "https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=EUR");
        $currentPrice = $response->getContent();
        $currentPrice = json_decode($currentPrice)->EUR;

        $date = new \DateTime();
        $ethEntity = new Eth();

        $ethEntity->setPrice($currentPrice);
        $ethEntity->setDate($date);

        $this->entityManager->persist($ethEntity);
        $this->entityManager->flush();

        $output->writeln("ETH Price Today is : " .$currentPrice. "€");


        return Command::SUCCESS;
    }
}
