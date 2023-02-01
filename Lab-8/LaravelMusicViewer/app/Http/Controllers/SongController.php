<?php

namespace App\Http\Controllers;

use App\DataAccess\AlbumRepository;
use App\DataAccess\SongRepository;
use App\ViewModels\CreateSongPageViewModel;
use App\ViewModels\NotFoundViewModel;
use App\ViewModels\RemoveSongViewModel;
use Illuminate\Http\Request;

class SongController extends Controller
{
    private AlbumRepository $albumRepository;
    private SongRepository $songRepository;

    public function __construct(AlbumRepository $albumRepository, SongRepository $songRepository)
    {
        $this->albumRepository = $albumRepository;
        $this->songRepository = $songRepository;
    }

    public function create(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'h' => 'required|min:0|max:24',
                'm' => 'required|min:0|max:60',
                's' => 'required|min:0|max:60',
                'albumId' => 'required',
            ]
        );

        $title = $validated['title'];
        $hours = $validated['h'];
        $minutes = $validated['m'];
        $seconds = $validated['s'];
        $albumId = $validated['albumId'];

        $this->songRepository->create($title, $hours . ':' . $minutes . ':' . $seconds, $albumId);

        return redirect()->route('albums.get', ['id' => $albumId]);
    }

    public function createPage(int $albumId)
    {
        if (!$this->albumRepository->existsById($albumId)) {
            return view(
                'not-found',
                ['model' => new NotFoundViewModel(route('albums.list'))]
            );
        }

        return view('create-song', ['model' => new CreateSongPageViewModel($albumId)]);
    }

    public function removePage(int $id, int $albumId)
    {
        if (!$this->songRepository->existsById($id)) {
            return view(
                'not-found',
                ['model' => new NotFoundViewModel(route('albums.get', ['id' => $albumId]))]
            );
        }

        $song = $this->songRepository->getById($id);
        return view('remove-song', ['model' => new RemoveSongViewModel($song)]);
    }

    public function remove(int $id, int $albumId)
    {
        $this->songRepository->remove($id);
        return redirect()->route('albums.get', ['id' => $albumId]);
    }
}
