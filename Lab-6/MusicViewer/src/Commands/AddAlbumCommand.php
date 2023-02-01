<?php

declare(strict_types=1);

namespace MusicViewer\Commands;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddAlbumCommand extends Command
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
    }

    protected static $defaultName = 'music:add-album';

    protected function configure()
    {
        $this
            ->setDescription('Create a new album')
            ->addArgument('title', InputArgument::REQUIRED, 'Album title')
            ->addOption('date', null, InputOption::VALUE_OPTIONAL, 'Album date');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $albumName = $input->getArgument('title');
        $albumDate = $input->getOption('date');

        $statement = $this->connection->prepare('insert into albums(title,date) values (?,?) ');
        $statement->execute([$albumName, $albumDate]);
        return self::SUCCESS;
    }
}
