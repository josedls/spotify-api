<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlbumResource;
use App\Services\SpotifyService;
use Illuminate\Http\Request;

class SpotifyController extends Controller
{
    private SpotifyService $spotifyService;

    public function __construct(SpotifyService $spotifyService)
    {
        $this->spotifyService = $spotifyService;
    }

    public function getAlbumsByArtistId(Request $request)
    {
        $artist = $request->query('q');

        $artistResponse = $this->spotifyService->searchArtist($artist);

        if ($artistResponse->status() == 200) {

            $idArtist = $artistResponse->content();

            $albumResponse = $this->spotifyService->getAlbums($idArtist);

            if ($albumResponse->status() == 200) {

                $albums = json_decode($albumResponse->content());

                return response()->json(AlbumResource::collection($albums->items), 200);

            } else
                return response()->json(['message' => 'Albums not found'], 404);
        } else
            return response()->json(['message' => 'Artist not found'], 404);
    }
}