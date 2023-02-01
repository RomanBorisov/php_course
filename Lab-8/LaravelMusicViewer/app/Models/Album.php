<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album
{
    public int $id;
    public string $title;
    public ?string $date;
}
