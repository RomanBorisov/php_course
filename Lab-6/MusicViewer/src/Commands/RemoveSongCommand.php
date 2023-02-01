<?php

declare(strict_types=1);

namespace MusicViewer\Commands;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveSongCommand extends Command
{
    protected static $defaultName = 'music:remove-song';

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
    }

    protected function configure()
    {
        $this
            ->setDescription('Remove song by id')
            ->addArgument('id', InputArgument::REQUIRED, 'Song id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $songId = $input->getArgument('id');

        if (!is_numeric($songId)) {
            $output->writeln('Wrong id format');

            return self::FAILURE;
        }

        $statement = $this->connection->prepare('select 1 from songs where id = ?');
        $statement->execute([$songId]);
        $songs = $statement->fetchAll();

        if (count($songs) === 0) {
            $output->writeln('Song not found');

            return self::FAILURE;
        }

        $statement = $this->connection->prepare('delete from songs where id = ?');
        $statement->execute([$songId]);

        return self::SUCCESS;
    }
}
