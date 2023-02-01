<?php

declare(strict_types=1);

namespace App\ViewModels;

use App\Models\Album;
use App\Models\Song;

class AlbumViewModel
{
    public Album $album;

    /** @var Song[] */
    public array $songs;

    /** @var int[] */
    public array $duration;


    /**
     * @param Album $album
     * @param Song[] $songs
     * @param int[] $duration
     */
    public function __construct(Album $album, array $songs, array $duration)
    {
        $this->album = $album;
        $this->songs = $songs;
        $this->duration = $duration;
    }

}
