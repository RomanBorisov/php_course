<?php

declare(strict_types=1);

namespace MusicViewer\Commands;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveAlbumCommand extends Command
{
    protected static $defaultName = 'music:remove-album';

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
    }


    protected function configure()
    {
        $this
            ->setDescription('Remove album by id')
            ->addArgument('id', InputArgument::REQUIRED, 'Album id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $albumId = $input->getArgument('id');

        if (!is_numeric($albumId)) {
            $output->writeln('Wrong id format');

            return self::FAILURE;
        }

        $statement = $this->connection->prepare('select 1 from albums where id = ?');
        $statement->execute([$albumId]);
        $albums = $statement->fetchAll();

        if (count($albums) === 0) {
            $output->writeln('Album not found');

            return self::FAILURE;
        }

        $statement = $this->connection->prepare('delete from albums where id = ?');
        $statement->execute([$albumId]);
        return self::SUCCESS;
    }
}
