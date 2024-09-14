<?php

namespace BamboleeDigital\OnboardingPackage\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->getTranslation('text', app()->getLocale()),
            'type' => $this->type,
            'options' => OptionResource::collection($this->whenLoaded('options')),
        ];
    }
}
