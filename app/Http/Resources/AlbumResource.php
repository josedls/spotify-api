<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'released' => Carbon::parse($this->release_date)->format('d-m-Y'),
            'tracks' => $this->total_tracks,
            'cover' => [
                'height' => '640',
                'width' => '640',
                'url' => (count($this->images) > 0) ? $this->images[0]->url : null,
            ]
        ];
    }
}