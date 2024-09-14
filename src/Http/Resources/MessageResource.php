<?php

namespace BamboleeDigital\OnboardingPackage\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'message' => $this->getTranslation('message', app()->getLocale()),
        ];
    }
}
