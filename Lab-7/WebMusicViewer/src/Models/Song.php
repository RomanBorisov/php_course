<?php

declare(strict_types=1);

namespace WebMusicViewer\Models;

class Song
{
    public int $id;
    public int $albumId;
    public ?string $title;
    public ?string $duration;
}
