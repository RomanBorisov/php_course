<?php

declare(strict_types=1);

namespace MusicViewer\Commands;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddSongCommand extends Command
{
    protected static $defaultName = 'music:add-song';
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create a new song')
            ->addArgument('albumId', InputArgument::REQUIRED, 'Album id')
            ->addArgument('duration', InputArgument::REQUIRED, 'Song duration')
            ->addOption('title', null, InputOption::VALUE_OPTIONAL, 'Song title');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $songTitle = $input->getOption('title');
        $albumId = $input->getArgument('albumId');
        $songDuration = $input->getArgument('duration');

        $statement = $this->connection->prepare('insert into songs(title,duration,album_id) values (?,?,?)');
        $statement->execute([$songTitle, $songDuration, $albumId]);
        return self::SUCCESS;
    }
}
