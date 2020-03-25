<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class Film extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'title' => $this->name,
            'year' => $this->year,
            'description' => Str::words($this->description, 10),
            'categories' => $this->categories,
            'actors' => $this->actors,
        ];
    }
}
