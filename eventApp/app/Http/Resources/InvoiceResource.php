<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
          'id'=>$this->id,
            'memberID' => $this->memberID,
            'status'=>$this->status,
            'billedDate' => $this->billedDate,
            'paidDate' => $this->paidDate
        ];
    }
}
