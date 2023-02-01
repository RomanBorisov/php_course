<?php

declare(strict_types=1);

namespace WebMusicViewer\Models;

class Album
{
    public int $id;
    public string $title;
    public ?string $date;
}
