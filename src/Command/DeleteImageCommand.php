<?php

namespace App\Command;

use App\Repository\AccountRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

#[AsCommand(
    name: 'app:delete-image',
    description: 'Delete images which arn\'t linked to an account',
)]
class DeleteImageCommand extends Command
{

    public function __construct(
        private AccountRepository $accountRepository,
        private string $uploadsDir
    )
    {
        parent::__construct();
    }

//    protected function configure(): void
//    {
//        $this
//            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
//        ;
//    }

    /**
     * @throws NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $count = 0;
        $fs = new Filesystem();
        $finder = new Finder();
        $finder->name(['*.png', '*.jpeg', '*.jpg']); // filtrer que ce format de fichier

        foreach ($finder->files()->in($this->uploadsDir.'/profile') as $file) {
            /** @var SplFileInfo $file */
            if (null === $this->accountRepository->findAccountForImage($file->getFilename())) {
                if ($fs->exists($file)) {
                    $fs->remove($file);
                    $count++;
                }
            }
        }

        $io->success(sprintf('Deleted "%d" old images.', $count));

        return Command::SUCCESS;
    }
}
