<?php

declare(strict_types=1);

namespace MusicViewer\Commands;

use MusicViewer\Models\SongModel;
use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListAlbumSongsCommand extends Command
{
    protected static $defaultName = 'music:list-album-songs';

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
    }

    protected function configure()
    {
        $this
            ->setDescription('List album songs')
            ->addArgument('albumId', InputArgument::REQUIRED, 'Album id');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $albumId = $input->getArgument('albumId');

        $statement = $this->connection->prepare('select * from songs where album_id = ?');

        $statement->execute([$albumId]);

        /** @var SongModel[] $songs */
        $songs = $statement->fetchAll(PDO::FETCH_CLASS, SongModel::class);

        $output->writeln('Songs:');
        foreach ($songs as $song) {
            $output->writeln("Id: {$song->id}, Album id: {$song->album_id}, Title: {$song->title}, Duration: {$song->duration}");
        }

        return self::SUCCESS;
    }
}
