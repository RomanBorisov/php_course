<?php

declare(strict_types=1);

namespace App\ViewModels;

use App\Models\Album;

class AlbumListViewModel
{
    /**
     * @var Album[]
     */
    public array $albums;

    /**
     * @param Album[] $albums
     */
    public function __construct(array $albums)
    {
        $this->albums = $albums;
    }

}
