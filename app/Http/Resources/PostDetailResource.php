<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
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
            'status' => 'STATUS_OK',
            'payload' => [
                'id' => $this->id,
                'title' => $this->title,
                'news_content' => $this->news_content,
                'image' => $this->image,
                'user_id' => $this->author,
                'author' => $this->whenLoaded('writer'),
                'comments' => $this->whenLoaded('comments', function () {
                    return collect($this->comments)->each(function ($comment) {
                        $comment->commenter;
                        return $comment;
                    });
                }),
                'total comments' => $this->whenLoaded('comments', function () {
                    return count($this->comments);
                })
            ]
        ];
    }
}
