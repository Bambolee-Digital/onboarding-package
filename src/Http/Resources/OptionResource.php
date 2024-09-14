<?php

namespace BamboleeDigital\OnboardingPackage\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->getTranslation('text', app()->getLocale()),
        ];
    }
}
