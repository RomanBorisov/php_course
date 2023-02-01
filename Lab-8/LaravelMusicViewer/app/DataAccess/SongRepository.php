<?php

namespace App\DataAccess;

use App\Models\Song;
use Illuminate\Database\DatabaseManager;

class SongRepository extends BaseRepository
{
    public function __construct(DatabaseManager $databaseManager)
    {
        parent::__construct($databaseManager, 'songs');
    }


    public function existsById(int $id): bool
    {
        return parent::existsById($id);
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
     *
     * @return Song[]
     */
    public function getByAlbumId(int $albumId): array
    {
        return $this->executeQuery(
            "
            select *
            from `{$this->tableName}`
            where `album_id` = ?;
        ",
            [$albumId],
            Song::class
        );
    }

    public function remove(int $id): void
    {
        $this->removeEntityById($id);
    }

    public function create(string $title, string $duration, int $albumId): int
    {
        return $this->insert(
            [
                'album_id' => $albumId,
                'title' => $title,
                'duration' => $duration,
            ]
        );
    }
}
