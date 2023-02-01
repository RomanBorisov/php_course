<?php

namespace WebMusicViewer\DataAccess;

use PDO;
use WebMusicViewer\Models\Song;

class SongRepository extends BaseRepository
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection, 'songs');
    }

    /**
     * @return Song[]
     */
    public function getAll(): array
    {
        return $this->getAllEntities(Song::class);
    }

    public function getById(int $id): ?Song
    {
        /** @var Song|null $song */
        $song = $this->getEntityById($id, Song::class);

        return $song;
    }

    /**
     * @param int $albumId
     * @return Song[]
     */
    public function getByAlbumId(int $albumId): array
    {
        $statement = $this->connection->prepare('select * from songs where album_id = ?');

        $statement->execute([$albumId]);

        return $statement->fetchAll(PDO::FETCH_CLASS, Song::class);
    }

    public function insert(string $title, string $duration, int $albumId): void
    {
        $statement = $this->connection->prepare('insert into songs(title,duration,album_id) values (?,?,?)');
        $statement->execute([$title, $duration, $albumId]);
    }

    public function remove(int $id): void
    {
        $this->removeEntityById($id);
    }
}
