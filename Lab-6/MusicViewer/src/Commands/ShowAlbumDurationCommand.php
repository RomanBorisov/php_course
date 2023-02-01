<?php

declare(strict_types=1);

namespace MusicViewer\Commands;

use PDO;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ShowAlbumDurationCommand extends Command
{
    protected static $defaultName = 'music:album-duration';
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        parent::__construct();

        $this->connection = $connection;
    }

    protected function configure()
    {
        $this
            ->setDescription('Show album duration by id')
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

        $statement = $this->connection->prepare('select songs.duration, albums.title from songs
                                                       join albums on albums.id = songs.album_id
                                                       where album_id = ?');
        $statement->execute([$albumId]);
        $songs = $statement->fetchAll(PDO::FETCH_ASSOC);

        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        foreach ($songs as $song) {
            $songDuration = explode(':', $song['duration']);
            $albumName = $song['title'];

            $hours += (int)$songDuration[0];
            $minutes += (int)$songDuration[1];
            $seconds += (int)$songDuration[2];
        }

        if ($seconds >= 60) {
            $minutes += $seconds / 60;
        }
        if ($minutes >= 60) {
            $hours += $minutes / 60;
        }

        $minutes %= 60;
        $seconds %= 60;

        $output->writeln("Album: {$albumName}. Duration: {$hours}:{$minutes}:{$seconds}");

        return self::SUCCESS;
    }
}
