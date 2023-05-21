<?php

namespace App\Services;

class GeneralService
{
    public static function getLocale($default = null)
    {
        $locale = session()->get('locale');
        if (in_array($locale, ['en', null, ''])) {
            $locale = $default;
        }

        return $locale;
    }
}
