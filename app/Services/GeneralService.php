<?php

namespace App\Services;


class GeneralService
{
    public static function getLocale()
    {
        $locale = session()->get('locale');
        if (in_array($locale, ['en', null, ''])) {
            $locale = null;
        }

        return $locale;
    }
}
