<?php

namespace App\Command;

use App\Service\HttpClientConnector;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'app:department',
    description: 'Add a short description for your command',
)]
class DepartmentCommand extends Command
{

    public function __construct(
        private HttpClientConnector $httpClientConnector,
        private EntityManagerInterface $em
    )
    {
        parent::__construct();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $jsonDept = $this->httpClientConnector->urlConnect('https://geo.api.gouv.fr/departements/');
        $departments = json_decode($jsonDept->getContent(), true);

        foreach ($departments as $department) {
            // pour chaque tableau de departements du Json
            // créer un nouveau departement à partir des clés du tableau "nom" et "code"
            // persister le nouveau departement
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
