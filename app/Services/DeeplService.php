<?php

namespace App\Services;

use App\Models\Setting;

class DeeplService
{
    const SOURCE = 'en';
    const TRANSTO = ['id', 'zh'];

    // TODO: make a func to translate html return html
    public static function translate($model)
    {
        $translator = new \DeepL\Translator(Setting::getByKey('G_DEEPL_AUTHKEY'));

        foreach (self::TRANSTO as $lang) {
            $result = $translator->translateText('Hello, world!', self::SOURCE, $lang);
            ($model::class)::updateOrCreate([
                'original_id' => $model->id,
                'lang' => $lang,
            ], [
                ...$model,
                'body' => $result->text,
                'original_id' => $model->id,
                'lang' => $lang
            ]);
        }
    }

    // TODO: make migrate service to check is any post and page not translated


}
