<?php


namespace App\ViewModels;


class CreateSongPageViewModel
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
