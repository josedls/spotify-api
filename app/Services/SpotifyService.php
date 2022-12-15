<?php
namespace App\Services;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class SpotifyService
{
    private $clientId;
    private $clientSecret;
    private const SPOTIFY_API_URL = 'https://api.spotify.com/v1';

    public function __construct()
    {
        $this->clientId = env('SPOTIFY_CLIENT_ID');
        $this->clientSecret = env('SPOTIFY_CLIENT_SECRET');
    }

    public function getToken()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            ])->asForm()
                ->post('https://accounts.spotify.com/api/token', [
                    'grant_type' => 'client_credentials',
                ]);
        } catch (RequestException $e) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents());
            $status = $e->getCode();
            $message = $errorResponse->error;

            throw new Exception($message, $status, $errorResponse);
        }

        $body = json_decode($response->getBody());

        return $body->access_token;

    }

    public function getResponse(string $endpoint, array $params = []): object
    {
        try {
            $token = $this->getToken();

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'Accepts' => 'application/json',
            ])->get(self::SPOTIFY_API_URL . $endpoint . '?' . http_build_query($params));
        } catch (RequestException $e) {
            $errorResponse = $e->getResponse();
            $status = $errorResponse->getStatusCode();
            ;
            $message = $errorResponse->getReasonPhrase();

            throw new Exception($message, $status, $errorResponse);
        }

        return json_decode($response->getBody());
    }

    public function searchArtist(string $query): object
    {
        $endpoint = '/search/';

        $params = [
            'q' => $query,
            'type' => 'artist',
            'limit' => 1,
            'offset' => null,
            'include_external' => null,
        ];

        $response = $this->getResponse($endpoint, $params);

        if (isset($response->artists) && count($response->artists->items) > 0) {
            $idArtist = $response->artists->items[0]->id;
            return response($idArtist, 200);
        } else
            return response()->json(['message' => 'Artist not found'], 404);
    }

    public function getAlbums(string $id): object
    {
        $endpoint = '/artists/' . $id . '/albums/';

        $params = [
            'include_groups' => null,
            'limit' => null,
            'offset' => null,
        ];

        $response = $this->getResponse($endpoint, $params);

        return response()->json($response, 200);
    }
}