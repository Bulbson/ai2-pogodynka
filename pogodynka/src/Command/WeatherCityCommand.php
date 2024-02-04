<?php

namespace App\Command;

use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WeatherCityCommand extends Command
{
    private $locationRepository;
    private $weatherUtil;
    public function __construct(LocationRepository $locationRepository, WeatherUtil $weatherUtil)
    {
        $this->locationRepository = $locationRepository;
        $this->weatherUtil = $weatherUtil;
        parent::__construct(null);
    }
    protected function configure()
    {
        $this
            ->setName('weather:city')
            ->setDescription('Displays measurements for city in country')
            ->addArgument('country_code', InputArgument::REQUIRED, 'Country code [eg. PL]')
            ->addArgument('city_name', InputArgument::REQUIRED, 'City name [eg. Szczecin]');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $countryCode = $input->getArgument('country_code');
        $cityName = $input->getArgument('city_name');

        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $cityName,
        ]);
        $measurements = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln('Location: ' . $location->getCity());
        foreach ($measurements as $measurement) {
            $io->writeln("\t" . $measurement->getDate()->format('Y-m-d') . ": " . $measurement->getCelsius());
        }
        return Command::SUCCESS;
    }
}
