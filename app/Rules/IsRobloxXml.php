<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsRobloxXml implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        // because this has to work with livewire, request()->hasFile() will not work
        // so this is just assuming that the supplied value is an UploadedFile object

        $asset = $value->get();

        libxml_use_internal_errors(true);
        $document = simplexml_load_string($asset);

        if (!$document)
        {
            // invalid XML
            libxml_clear_errors();
            return false;
        }

        libxml_use_internal_errors(false);

        // now we just check for some nodes which **should** appear in all XML assets
        if (!$document->getName() == 'roblox') return false;
        if (count($document->xpath('//External')) < 2) return false;
        if (!count($document->xpath('//Item'))) return false;
        if (!count($document->xpath('//Properties'))) return false;

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __('Not a valid Roblox XML asset.');
    }
}
