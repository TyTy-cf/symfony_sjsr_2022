<?php

namespace App\Command;

use App\Repository\AccountRepository;
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

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $count = 0;

        $fs = new Filesystem();
        $finder = new Finder();
        $finder->files()->in($this->uploadsDir.'/profile');
        $finder->name(['*.png', '*.jpeg', '*.jpg']);
        dump($finder->files());
        if ($finder->hasResults()) {
            /** @var SplFileInfo $file */
            $file = $finder->getIterator()->current();
            dump($file);
        }
//        if ($fs->exists($fileName)) {
//            $fs->remove($fileName);
//        }

        $io->success(sprintf('Deleted "%d" old images.', $count));

        return Command::SUCCESS;
    }
}
