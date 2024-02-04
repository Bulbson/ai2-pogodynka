<?php
namespace App\Command;
use App\Repository\LocationRepository;
use App\Service\WeatherUtil;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
class WeatherLocationCommand extends Command
{
    private $locationRepository;
    private $weatherUtil;
    public function __construct(LocationRepository $locationRepository, WeatherUtil $weatherUtil)
    {
        $this->locationRepository = $locationRepository;
        $this->weatherUtil = $weatherUtil;
        parent::__construct();
    }
    protected function configure()
    {
        $this
            ->setName('weather:location')
            ->setDescription('Wyswietlenie danych dla lokacji')
            ->addArgument('id', InputArgument::REQUIRED, 'Location ID');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $locationId = $input->getArgument('id');
        $location = $this->locationRepository->find($locationId);
        $measurements = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln('Location: ' . $location->getCity());
        foreach ($measurements as $measurement) {
            $io->writeln("\t" . $measurement->getDate()->format('Y-m-d') . ": " . $measurement->getCelsius());
        }
        return Command::SUCCESS;
    }
}
