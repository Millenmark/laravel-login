<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
            'avatarUrl' => $this->avatar_url,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'email' => $this->email,
            'phoneNumber' => $this->phone_number,
            'address' => $this->address,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
            'zipCode' => $this->zip_code,
            'company' => $this->company,
            'isVerified' => $this->isVerified,
            'isPublic' => $this->isPublic,
            'about' => $this->about,
            'status' => $this->status,
            'roleId' => $this->role_id,
            'role' => [
                'roleId' => optional($this->role)->id,
                'roleName' => optional($this->role)->role_name,
                'rolePermissions' => optional($this->role)->role_permissions,
            ],
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\JsonResponse  $response
     * @return void
     */
    public function withResponse($request, $response)
    {

        $response->setData($this->toArray($request));
    }
}
