<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Setting;

class DeeplService
{
    const SOURCE = 'en';
    const TRANSTO = ['id', 'zh'];

    public static function translate($text, $title)
    {
        $results = [];
        foreach (self::TRANSTO as $lang) {
            $translator = new \DeepL\Translator(Setting::getByKey('G_DEEPL_AUTHKEY'));
            $result = $translator->translateText([$title, $text], self::SOURCE, $lang);
            info('translated', $result);
            $results[$lang] = [$result[0]->text, $result[1]->text];
        }

        return $results;
    }

    public static function translatePost(Post $post)
    {
        $translateds = self::translate($post->body, $post->title);

        foreach ($translateds as $lang => $translate) {
            $slug =  str($translate[0])->slug() == "" ? $post->slug . '-' . $lang : str($translate[0])->slug();
            $transPost = Post::updateOrCreate([
                'original_id' => $post->id,
                'lang' => $lang,
            ], [
                'slug' => $slug,
                'title' => $translate[0],
                'body' => $translate[1],
                'meta_tag' => $post->meta_tag,
                'cover_image' => $post->cover_image,
                'is_publish' => $post->is_publish,
                'original_id' => $post->id,
                'lang' => $lang,
                'created_by' => $post->created_by
            ]);

            PostTag::where('post_id', $transPost->id)->delete();
            foreach (collect($post->tags) as $tag) {
                PostTag::create([
                    'post_id' => $transPost->id,
                    'tag_id' => $tag->id,
                ]);
            }
        }
    }

    public static function translatePage(Page $page)
    {
        foreach (self::TRANSTO as $lang) {
            $translator = new \DeepL\Translator(Setting::getByKey('G_DEEPL_AUTHKEY'));
            $result = $translator->translateText($page->body, self::SOURCE, $lang);
            info('translated', [$result]);

            Page::updateOrCreate([
                'lang' => $lang,
                'original_id' => $page->id
            ], [
                'key' => $lang . '/' . $page->key,
                'title' => $page->title,
                'body' => $result->text,
                'meta_tag' => $page->meta_tag,
                'attribute' => $page->attribute,
                'flag' => $page->flag,
                'original_id' => $page->id,
                'lang' => $lang,
            ]);
        }
    }
}
