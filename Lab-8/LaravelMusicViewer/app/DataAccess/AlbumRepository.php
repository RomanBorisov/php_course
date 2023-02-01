<?php

namespace App\DataAccess;

use App\Models\Album;
use DateTime;
use Illuminate\Database\DatabaseManager;

class AlbumRepository extends BaseRepository
{
    public function __construct(DatabaseManager $databaseManager)
    {
        parent::__construct($databaseManager, 'albums');
    }

    /**
     * @return Album[]
     */
    public function getAll(): array
    {
        return $this->getAllEntities(Album::class);
    }

    public function getById(int $id): ?Album
    {
        /** @var Album|null $album */
        $album = $this->getEntityById($id, Album::class);

        return $album;
    }

    public function existsById(int $id): bool
    {
        return parent::existsById($id);
    }

    public function create(string $title, DateTime $date): int
    {
        return $this->insert(
            [
                'title' => $title,
                'date' => $date,
            ]
        );
    }

    public function remove(int $id): void
    {
        parent::removeEntityById($id);
    }
}
