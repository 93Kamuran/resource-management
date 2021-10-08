<?php


namespace App\Http\Resources;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'id' => $this->id,
                'type' => 'links',
                'attributes' => [
                    'title' => $this->title,
                    'link' => $this->link,
                    'target' => $this->target,
                    'created' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                    'modified' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
                ],
            ],
            'links' => [
                'self' => url('/links/' . $this->id),
            ]
        ];
    }
}