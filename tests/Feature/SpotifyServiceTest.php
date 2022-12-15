<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;

class SpotifyServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testServiceReturnAlbumsByArtistInValidFormat()
    {
        $this->json('get', 'api/v1/albums?q=nirvana')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure(
                [

                    '*' => [
                        'name',
                        'released',
                        'tracks',
                        'cover' => [
                            'height',
                            'width',
                            'url'
                        ]
                    ]

                ]
            );
    }
}