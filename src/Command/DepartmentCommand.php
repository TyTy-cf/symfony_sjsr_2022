<?php

namespace App\Command;

use App\Entity\Department;
use App\Repository\DepartmentRepository;
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
        private EntityManagerInterface $em,
        private DepartmentRepository $departmentRepository
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
        $countDpt = 0;

        foreach ($departments as $department) {
            if (null === $this->departmentRepository->findOneBy(['code' => $department['code']])) {
                $newDpt = (new Department())
                    ->setName($department['nom'])
                    ->setCode($department['code'])
                ;
                $this->em->persist($newDpt);
                $countDpt++;
            }
        }
        $this->em->flush();

        $io->success($countDpt . ' département(s) ajouté(s)');

        return Command::SUCCESS;
    }
}
