<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $payment_proof = null;
        if ($this->payment_proof != null) {
            if (strpos($this->payment_proof, 'http') === 0) {
                $payment_proof = $this->payment_proof;
            } else if (!$this->payment_proof) {
                $payment_proof = asset('storage/images/payment_proof/' . $this->payment_proof);
            }
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'payment_method' => $this->payment_method,
            'payment_proof' => $payment_proof,
            'payment_date' => $this->payment_date,
            'delivery_address' => $this->delivery_address,
            'verified_at' => $this->verified_at,
            'detail_transaction' => DetailTransactionResource::collection($this->whenLoaded('detailTransaction')),
            'user' => new UserResource($this->whenLoaded('user')),
            'verifiedBy' =>  new AdminResource($this->whenLoaded('verifiedBy'))
        ];
    }
}
