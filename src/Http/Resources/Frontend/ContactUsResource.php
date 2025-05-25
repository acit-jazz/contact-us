<?php

namespace AcitJazz\ContactUs\Http\Resources\Frontend;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ContactUsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->format('Y-m-d H:i') : null,
        ];
    }
}
