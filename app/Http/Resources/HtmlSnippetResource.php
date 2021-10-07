<?php


namespace App\Http\Resources;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HtmlSnippetResource extends JsonResource
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
                'type' => 'html-snippets',
                'attributes' => [
                    'title' => $this->title,
                    'description' => url($this->description),
                    'html' => url($this->html),
                    'created' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
                    'modified' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
                ],
            ],
            'links' => [
                'self' => url('/html-snippets/' . $this->id),
            ]
        ];
    }
}