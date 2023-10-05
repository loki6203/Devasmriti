<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Commonreturn extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
    public function toResponse($request)
    {
        $respData = parent::toArray($request);
        if(isset($respData['success']) && $respData['success']==0){
            $setStatusCode = 400;
        }else{
            switch ($request->method()) {
                case 'POST':
                    $setStatusCode = 201;
                    break;
                case 'GET':
                    $setStatusCode = 200;
                    break;
                case 'DELETE':
                    $setStatusCode = 204;
                    break;
                case 'PUT':
                    $setStatusCode = 200;
                    break;
                case 'PATCH':
                    $setStatusCode = 200;
                    break;
                default:
                    $setStatusCode = 200;
                    break;
            }
        }
        return parent::toResponse($request)->setStatusCode($setStatusCode);
    }
}
