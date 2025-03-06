<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'shelf' => $this->when($this->loadBooks, function(){
                $shelfData = [];
                // echo $userData->shelf;
                foreach($this->shelf as $shelf){
                    $bookData = $shelf->shelfHasBook->pluck('book.name');
                    $shelfData[$shelf->name] = $bookData;
                }
                return $shelfData;
            }),
            'shelves' => $this->when(!$this->loadBooks, function(){
                return $this->shelf->pluck('name')->toArray();
            })
        ];
    }
}
