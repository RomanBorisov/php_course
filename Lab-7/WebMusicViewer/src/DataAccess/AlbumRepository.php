<?php

namespace WebMusicViewer\DataAccess;

use PDO;
use WebMusicViewer\Models\Album;

class AlbumRepository extends BaseRepository
{
    public function __construct(PDO $connection)
    {
        parent::__construct($connection, 'albums');
    }

    /**
     * @return Album[]
     */
    public function getAll(): array
    {
        return $this->getAllEntities(Album::class);
    }

    public function remove(int $id)
    {
        $this->removeEntityById($id);
    }

    public function getById(int $id): ?Album
    {
        /** @var Album|null $album */
        $album = $this->getEntityById($id, Album::class);

        return $album;
    }

    public function insert(string $albumName): void
    {
        $statement = $this->connection->prepare('insert into albums(title,date) values (?,now()) ');
        $statement->execute([$albumName]);
    }
}
