<?php

declare(strict_types=1);

namespace Scene2d\Models;

class SceneRectangle
{
    public ?ScenePoint $vertex1 = null;

    public ?ScenePoint $vertex2 = null;

    public function __construct(?ScenePoint $vertex1 = null, ?ScenePoint $vertex2 = null)
    {
        $this->vertex1 = $vertex1;
        $this->vertex2 = $vertex2;
    }
}
