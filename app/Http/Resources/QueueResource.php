<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QueueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $return  = array(
            'id' => $this->id,
            'email' => $this->email,
            'message' => $this->message,
            'scheduled_at' => $this->scheduled_at,
            'sent_at' => $this->sent_at
        );

        return $return;
    }
}
