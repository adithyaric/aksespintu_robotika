<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AksesPintuResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'tag' => $this->id_rfid,
            'pin' => $this->pin,
            'nama' => $this->user->name,
            'jurusan' => $this->user->jurusan,
            'angkatan' => $this->user->angkatan,
            'lulus' => $this->user->lulus,
        ];
    }
}
