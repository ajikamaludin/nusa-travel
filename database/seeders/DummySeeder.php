<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Faq;
use App\Models\FastboatPlace;
use App\Models\FastboatTrack;
use App\Models\File;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->setting();
        $this->place();
        $this->track();
        $this->blog();
        $this->page();
        $this->faq();
        $this->file();
        $this->customer();
    }

    public function setting()
    {
        $setting = [
            ['id' => Str::uuid(), 'key' => 'G_SITE_NAME', 'value' => 'Nusa Travel', 'type' => 'text', 'label' => 'Site Name'],
            ['id' => Str::uuid(), 'key' => 'G_SITE_LOGO', 'value' => 'logo-side.png ', 'type' => 'image', 'label' => 'Site Logo'],
            [
                'id' => Str::uuid(), 
                'key' => 'G_SITE_ABOUT', 
                'value' => 'An Indonesia\'s leading provider of fast boat tickets, we offer the most reliable and efficient transport options for island-hopping. Our main fast boat, the Ekajaya Fast Boat, is equipped with modern facilities and offers a comfortable and safe journey to your desired destination.', 
                'type' => 'textarea',
                'label' => 'Site About'
            ],
            [
                'id' => Str::uuid(), 
                'key' => 'G_SITE_WELCOME', 
                'value' => 'Welcome To Nusa Travel', 
                'type' => 'text',
                'label' => 'Welcome Banner'
            ],
            [
                'id' => Str::uuid(), 
                'key' => 'G_SITE_SUBWELCOME', 
                'value' => 'Your One-Stop Destination for Island Hopping in Indonesia', 
                'type' => 'text',
                'label' => 'Sub Welcome Banner'
            ],
            ['id' => Str::uuid(), 'key' => 'G_SITE_META_DESC', 'value' => 'description here', 'type' => 'textarea', 'label' => 'Site Meta'],
            ['id' => Str::uuid(), 'key' => 'G_SITE_META_KEYWORD', 'value' => 'keyword here', 'type' => 'textarea', 'label' => 'Site Keyword'],
            ['id' => Str::uuid(), 'key' => 'G_LANDING_SLIDE_1', 'value' => 'images/1.jpg', 'type' => 'image', 'label' => 'SLIDE 1'],
            ['id' => Str::uuid(), 'key' => 'G_LANDING_SLIDE_2', 'value' => 'images/2.jpg', 'type' => 'image', 'label' => 'SLIDE 2'],
            ['id' => Str::uuid(), 'key' => 'G_LANDING_SLIDE_3', 'value' => 'images/3.jpg', 'type' => 'image', 'label' => 'SLIDE 3'],

            ['id' => Str::uuid(), 'key' => 'midtrans_server_key', 'value' => 'SB-Mid-server-UA0LQbY4aALV0CfLLX1v7xs8', 'type' => 'text', 'label' => 'Midtrans Server Key'],
            ['id' => Str::uuid(), 'key' => 'midtrans_client_key', 'value' => 'SB-Mid-client-xqqkspzoZOM10iUG', 'type' => 'text', 'label' => 'Midtrans Client Key'],
            ['id' => Str::uuid(), 'key' => 'midtrans_merchant_id', 'value' => 'G561244367', 'type' => 'text', 'label' => 'Midtrans Merchatn Id'],
        ];

        Setting::insert($setting);
    }

    public function place()
    {
        $places = [
            ['id' => Str::uuid(), 'name' => 'SERANGAN'],
            ['id' => Str::uuid(), 'name' => 'LEMBONGAN'],
            ['id' => Str::uuid(), 'name' => 'PENIDA'],
            ['id' => Str::uuid(), 'name' => 'PADANGBAI'],
            ['id' => Str::uuid(), 'name' => 'GILI TRAWANGAN'],
            ['id' => Str::uuid(), 'name' => 'MENO'],
            ['id' => Str::uuid(), 'name' => 'AIR'],
            ['id' => Str::uuid(), 'name' => 'BANGSAL'],
            ['id' => Str::uuid(), 'name' => 'SENGGIGI'],
        ];

        FastboatPlace::insert($places);
    }

    public function track()
    {
        $SERANGAN = FastboatPlace::where('name', 'SERANGAN')->first()->id;
        $LEMBONGAN = FastboatPlace::where('name', 'LEMBONGAN')->first()->id;
        $PENIDA = FastboatPlace::where('name', 'PENIDA')->first()->id;
        $PADANGBAI = FastboatPlace::where('name', 'PADANGBAI')->first()->id;
        $GILI = FastboatPlace::where('name', 'GILI TRAWANGAN')->first()->id;
        $MENO = FastboatPlace::where('name', 'MENO')->first()->id;
        $AIR = FastboatPlace::where('name', 'AIR')->first()->id;
        $BANGSAL = FastboatPlace::where('name', 'BANGSAL')->first()->id;
        $SENGGIGI = FastboatPlace::where('name', 'SENGGIGI')->first()->id;

        $tracks = [
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "170000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "170000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $PENIDA,
                "price" => "170000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $PENIDA,
                "price" => "170000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $GILI,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $MENO,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $AIR,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $BANGSAL,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SERANGAN,
                "fastboat_destination_id" => $SENGGIGI,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $GILI,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $MENO,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $AIR,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $BANGSAL,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $SENGGIGI,
                "fastboat_destination_id" => $SERANGAN,
                "price" => "560000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $GILI,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $MENO,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $AIR,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $BANGSAL,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PENIDA,
                "fastboat_destination_id" => $SENGGIGI,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $GILI,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $MENO,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $AIR,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $BANGSAL,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $SENGGIGI,
                "fastboat_destination_id" => $PENIDA,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $GILI,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $MENO,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $AIR,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $BANGSAL,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $LEMBONGAN,
                "fastboat_destination_id" => $SENGGIGI,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $GILI,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $MENO,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $AIR,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $BANGSAL,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $SENGGIGI,
                "fastboat_destination_id" => $LEMBONGAN,
                "price" => "510000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $GILI,
                "price" => "310000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $MENO,
                "price" => "310000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $AIR,
                "price" => "310000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $BANGSAL,
                "price" => "310000",
            ],
            [
                "fastboat_source_id" => $GILI,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $MENO,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $AIR,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $BANGSAL,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $PADANGBAI,
                "fastboat_destination_id" => $SENGGIGI,
                "price" => "360000",
            ],
            [
                "fastboat_source_id" => $SENGGIGI,
                "fastboat_destination_id" => $PADANGBAI,
                "price" => "360000",
            ],
        ];

        $tracks = collect($tracks)->map(function ($track) {
            return [
                ...$track,
                "id" => Str::uuid(),
                "capacity" => "100",
                "arrival_time" => "10:00",
                "departure_time" => "11:00",
                "is_publish" => "1",
            ];
        })->toArray();

        FastboatTrack::insert($tracks);
    }

    public function blog()
    {
        $tags = [
            ['id' => Str::uuid(), 'name' => 'News'],
            ['id' => Str::uuid(), 'name' => 'Tours'],
            ['id' => Str::uuid(), 'name' => 'Destination'],
            ['id' => Str::uuid(), 'name' => 'Boat']
        ];

        Tag::insert($tags);


        $posts = [
            ['title' => 'Uluwatu Kecak Fire and Dance Show Ticket in Bali	', 'file' => '/blog/post1.txt', 'image' => 'images/post1.webp'],
            ['title' => 'Nusa Penida Day Tour from Bali	', 'file' => '/blog/post2.txt', 'image' => 'images/post2.webp'],
            ['title' => 'Nusa Penida Instagram Tour from Bali', 'file' => '/blog/post3.txt', 'image' => 'images/post3.webp'],
            ['title' => 'Tanjung Benoa Watersports in Bali by Bali Bintang Dive and Watersport	', 'file' => '/blog/post4.txt', 'image' => 'images/post4.webp'],
        ];

        foreach($posts as $p) {
            // foreach(range(0, 4) as $r) {
                $post = Post::create([
                    'slug' => Str::slug($p['title']),
                    'meta_tag' => '',
                    'cover_image' => $p['image'],
                    'is_publish' => Post::PUBLISH,
                    'title' => $p['title'],
                    'body' => file_get_contents(__DIR__.$p['file']),
                    'created_by' => User::first()->id,
                ]);

                PostTag::create([
                    'post_id' => $post->id,
                    'tag_id' => $tags[rand(0,3)]['id']
                ]);
            // }
        }
    }

    public function page()
    {
        $pages = [
            ['key' => 'term-of-service', 'title' => 'Term Of Service', 'file' => '/pages/termofservice.txt'],
            ['key' => 'privacy-policy', 'title' => 'Privacy Policy', 'file' => '/pages/privacypolicy.txt'],
            ['key' => 'disclaimer', 'title' => 'Disclaimer', 'file' => '/pages/disclaimer.txt'],
            ['key' => 'refundpolicy', 'title' => 'Refund Policy', 'file' => '/pages/refundpolicy.txt'],
            ['key' => 'cookiepolicy', 'title' => 'Cookie Policy', 'file' => '/pages/cookiepolicy.txt'],
            ['key' => 'aboutus', 'title' => 'About Us', 'file' => '/pages/aboutus.txt'],
        ];

        foreach($pages as $page) {
            Page::create([
                'key' => $page['key'],
                'title' => $page['title'],
                'body' => file_get_contents(__DIR__.$page['file'])
            ]);
        }
    }

    public function faq()
    {
        $faqs = [
            ['id' => Str::uuid(), 'question' => 'Why Nusa Travel ? ', 'answer' => "<div>
            <div>An Indonesia's leading provider of fast boat tickets, we offer the most reliable and</div>
            <div>efficient transport options for island-hopping. Our main fast boat, the Ekajaya Fast Boat,</div>
            <div>is equipped with modern facilities and offers a comfortable and safe journey to your</div>
            <div>desired destination.</div>
            </div>", 'order' => 1],
            ['id' => Str::uuid(), 'question' => 'Can i refund my booking ?', 'answer' => "<div>Sure</div>", 'order' => 2],
            ['id' => Str::uuid(), 'question' => 'Can i change my plan ?', 'answer' => "<div>Sure</div>", 'order' => 3],
            ['id' => Str::uuid(), 'question' => 'How to apply promo ?', 'answer' => "<div>Sure</div>", 'order' => 4],
        ];

        Faq::insert($faqs);
    }

    public function file()
    {
        $files = [
            ['id' => Str::uuid(), 'name' => 'Pantai Gili Trawangank', 'path' => 'images/4.jpg', 'show_on' => File::MAIN_DISPLAY],
            ['id' => Str::uuid(), 'name' => 'Gili Trawangank 1', 'path' => 'images/1.jpg', 'show_on' => File::SIDE1_DISPLAY],
            ['id' => Str::uuid(), 'name' => 'Gili Trawangank 2', 'path' => 'images/2.jpg', 'show_on' => File::SIDE2_DISPLAY],
            ['id' => Str::uuid(), 'name' => 'Sample', 'path' => 'images/3.jpg', 'show_on' => File::NO_DISPLAY],
        ];

        File::insert($files);
    }

    public function customer()
    {
        Customer::create([
            "name" => "Dummy User",
            "email" => "user@mail.com",
            "phone" => "083840745543",
            "password" => bcrypt("password"),
            "address" => "indonesia",
            "nation" => Customer::WNA,
            "is_active" => Customer::ACTIVE,
            "email_varified_at" => now(),
        ]);
    }
}
