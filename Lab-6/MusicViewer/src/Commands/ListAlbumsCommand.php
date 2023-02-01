<?php

declare(strict_types=1);

namespace MusicViewer\Commands;

use MusicViewer\Models\AlbumModel;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAlbumsCommand extends Command
{
    protected static $defaultName = 'music:list-album';

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
    }

    protected function configure()
    {
        $this->setDescription('List albums');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $statement = $this->connection->query('select * from albums');

        /** @var AlbumModel[] $albums */
        $albums = $statement->fetchAll(PDO::FETCH_CLASS, AlbumModel::class);

        $output->writeln('Albums:');
        foreach ($albums as $album) {
            $date = $album->date ?? 'None';

            $output->writeln("Id: {$album->id}, Title: {$album->title}, Date: {$date}");
        }

        return self::SUCCESS;
    }
}
