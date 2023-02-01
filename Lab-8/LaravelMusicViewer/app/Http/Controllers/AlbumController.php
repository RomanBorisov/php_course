<?php

namespace App\Http\Controllers;

use App\DataAccess\AlbumRepository;
use App\DataAccess\SongRepository;
use App\Models\Song;
use App\ViewModels\AlbumListViewModel;
use App\ViewModels\AlbumViewModel;
use App\ViewModels\NotFoundViewModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    private AlbumRepository $albumRepository;
    private SongRepository $songRepository;

    public function __construct(AlbumRepository $albumRepository, SongRepository $songRepository)
    {
        $this->albumRepository = $albumRepository;
        $this->songRepository = $songRepository;
    }

    public function getAll()
    {
        $albums = $this->albumRepository->getAll();

        return view('album-list', ['model' => new AlbumListViewModel($albums)]);
    }

    public function getById(int $albumId)
    {
        if (!$this->albumRepository->existsById($albumId)) {
            return view(
                'not-found',
                ['model' => new NotFoundViewModel(route('album-list'))]
            );
        }

        $album = $this->albumRepository->getById($albumId);
        $songs = $this->songRepository->getByAlbumId($albumId);
        $duration = $this->summaryDuration($songs);

        return view('album', ['model' => new AlbumViewModel($album, $songs, $duration)]);
    }

    public function createPage()
    {
        return view('create-album');
    }

    public function create(Request $request)
    {
        $validated = $request->validate(
            [
                'title' => 'required|string|max:255',
                'date' => 'required',
            ]
        );

        $title = $validated['title'];
        $date = Carbon::parse($validated['date']);

        $albumId = $this->albumRepository->create($title, $date);

        return redirect()->route('albums.get', ['id' => $albumId]);
    }

    public function remove(int $id)
    {
        $this->albumRepository->remove($id);

        return $this->getAll();
    }

    /**
     * @param Song[] $songs
     * @return int[]
     */
    private function summaryDuration(array $songs): array
    {
        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        foreach ($songs as $song) {
            $songDuration = explode(':', $song->duration);

            $hours += (int)$songDuration[0];
            $minutes += (int)$songDuration[1];
            $seconds += (int)$songDuration[2];
        }

        if ($seconds >= 60) {
            $minutes += $seconds / 60;
        }
        if ($minutes >= 60) {
            $hours += $minutes / 60;
        }

        $minutes %= 60;
        $seconds %= 60;

        return ['hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds];
    }
}
