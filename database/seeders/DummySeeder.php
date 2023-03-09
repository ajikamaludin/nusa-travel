<?php

namespace Database\Seeders;

use App\Models\CarRental;
use App\Models\Customer;
use App\Models\Faq;
use App\Models\File;
use App\Models\Page;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\TourPackage;
use App\Models\User;
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
        $this->blog();
        $this->page();
        $this->faq();
        $this->file();
        $this->customer();
        $this->car_rentals();
        $this->tour_packages();
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
                'label' => 'Site About',
            ],
            [
                'id' => Str::uuid(),
                'key' => 'G_SITE_WELCOME',
                'value' => 'Welcome To Nusa Travel',
                'type' => 'text',
                'label' => 'Welcome Banner',
            ],
            [
                'id' => Str::uuid(),
                'key' => 'G_SITE_SUBWELCOME',
                'value' => 'Your One-Stop Destination for Island Hopping in Indonesia',
                'type' => 'text',
                'label' => 'Sub Welcome Banner',
            ],
            ['id' => Str::uuid(), 'key' => 'G_SITE_META_DESC', 'value' => 'description here', 'type' => 'textarea', 'label' => 'Site Meta'],
            ['id' => Str::uuid(), 'key' => 'G_SITE_META_KEYWORD', 'value' => 'keyword here', 'type' => 'textarea', 'label' => 'Site Keyword'],
            ['id' => Str::uuid(), 'key' => 'G_LANDING_SLIDE_1', 'value' => 'images/1.jpg', 'type' => 'image', 'label' => 'SLIDE 1'],
            ['id' => Str::uuid(), 'key' => 'G_LANDING_SLIDE_2', 'value' => 'images/2.jpg', 'type' => 'image', 'label' => 'SLIDE 2'],
            ['id' => Str::uuid(), 'key' => 'G_LANDING_SLIDE_3', 'value' => 'images/3.jpg', 'type' => 'image', 'label' => 'SLIDE 3'],

            ['id' => Str::uuid(), 'key' => 'midtrans_server_key', 'value' => 'SB-Mid-server-UA0LQbY4aALV0CfLLX1v7xs8', 'type' => 'text', 'label' => 'Midtrans Server Key'],
            ['id' => Str::uuid(), 'key' => 'midtrans_client_key', 'value' => 'SB-Mid-client-xqqkspzoZOM10iUG', 'type' => 'text', 'label' => 'Midtrans Client Key'],
            ['id' => Str::uuid(), 'key' => 'midtrans_merchant_id', 'value' => 'G561244367', 'type' => 'text', 'label' => 'Midtrans Merchatn Id'],
            ['id' => Str::uuid(), 'key' => 'G_WHATSAPP_FLOAT_ENABLE', 'value' => '1', 'type' => 'checkbox', 'label' => 'Whatsapp Float Button Enable'],
            ['id' => Str::uuid(), 'key' => 'G_WHATSAPP_URL', 'value' => 'https://wa.me/6287820231626', 'type' => 'text', 'label' => 'Whatsapp Url'],
            ['id' => Str::uuid(), 'key' => 'G_WHATSAPP_TEXT', 'value' => 'How can I help you ?', 'type' => 'text', 'label' => 'Whatsapp Text'],
        ];

        Setting::insert($setting);
    }

    public function blog()
    {
        $tags = [
            ['id' => Str::uuid(), 'name' => 'News'],
            ['id' => Str::uuid(), 'name' => 'Tours'],
            ['id' => Str::uuid(), 'name' => 'Destination'],
            ['id' => Str::uuid(), 'name' => 'Boat'],
        ];

        Tag::insert($tags);

        $posts = [
            ['title' => 'Uluwatu Kecak Fire and Dance Show Ticket in Bali	', 'file' => '/blog/post1.txt', 'image' => 'images/post1.webp'],
            ['title' => 'Nusa Penida Day Tour from Bali	', 'file' => '/blog/post2.txt', 'image' => 'images/post2.webp'],
            ['title' => 'Nusa Penida Instagram Tour from Bali', 'file' => '/blog/post3.txt', 'image' => 'images/post3.webp'],
            ['title' => 'Tanjung Benoa Watersports in Bali by Bali Bintang Dive and Watersport	', 'file' => '/blog/post4.txt', 'image' => 'images/post4.webp'],
        ];

        foreach ($posts as $p) {
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
                'tag_id' => $tags[rand(0, 3)]['id'],
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

        foreach ($pages as $page) {
            Page::create([
                'key' => $page['key'],
                'title' => $page['title'],
                'body' => file_get_contents(__DIR__.$page['file']),
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
            ['id' => Str::uuid(), 'question' => 'Can i refund my booking ?', 'answer' => '<div>Sure</div>', 'order' => 2],
            ['id' => Str::uuid(), 'question' => 'Can i change my plan ?', 'answer' => '<div>Sure</div>', 'order' => 3],
            ['id' => Str::uuid(), 'question' => 'How to apply promo ?', 'answer' => '<div>Sure</div>', 'order' => 4],
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
            'name' => 'Dummy User',
            'email' => 'user@mail.com',
            'phone' => '083840745543',
            'password' => bcrypt('password'),
            'address' => 'indonesia',
            'nation' => Customer::WNA,
            'is_active' => Customer::ACTIVE,
            'email_varified_at' => now(),
        ]);
    }

    public function car_rentals()
    {
        $cars = [
            [
                'id' => Str::uuid(),
                'name' => 'Avanza',
                'price' => '150000',
                'description' => 'SERANGAN PORT - HOTEL (Kuta, Seminyak, Nusa dua)',
                'capacity' => '4',
                'luggage' => '2',
                'transmission' => 'Manual',
                'cover_image' => 'images/avanza.png',
                'is_publish' => CarRental::READY,
                'car_owned' => '4',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Elf Shot',
                'price' => '225000',
                'description' => 'SERANGAN PORT - HOTEL (Kuta, Seminyak, Nusa dua)',
                'capacity' => '10',
                'luggage' => '5',
                'transmission' => 'Manual',
                'cover_image' => 'images/elf_short.jpg',
                'is_publish' => CarRental::READY,
                'car_owned' => '4',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Long Elf / Hiace',
                'price' => '350000',
                'description' => 'SERANGAN PORT - HOTEL (Kuta, Seminyak, Nusa dua)',
                'capacity' => '14',
                'luggage' => '6',
                'transmission' => 'Manual',
                'cover_image' => 'images/hiace.png',
                'is_publish' => CarRental::READY,
                'car_owned' => '4',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Bus',
                'price' => '600000',
                'description' => 'SERANGAN PORT - HOTEL (Kuta, Seminyak, Nusa dua)',
                'capacity' => '28',
                'luggage' => '20',
                'transmission' => 'Manual',
                'cover_image' => 'images/bus.png',
                'is_publish' => CarRental::READY,
                'car_owned' => '1',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Bus',
                'price' => '700000',
                'description' => 'SERANGAN PORT - HOTEL (Kuta, Seminyak, Nusa dua)',
                'capacity' => '35',
                'luggage' => '30',
                'transmission' => 'Manual',
                'cover_image' => 'images/bus.png',
                'is_publish' => CarRental::READY,
                'car_owned' => '1',
            ],
            //
            [
                'id' => Str::uuid(),
                'name' => 'Avanza',
                'price' => '250000',
                'description' => 'SERANGAN PORT - HOTEL (Ubud / Tanah Lot)',
                'capacity' => '4',
                'luggage' => '2',
                'transmission' => 'Manual',
                'cover_image' => 'images/avanza.png',
                'is_publish' => CarRental::READY,
                'car_owned' => '4',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Elf Shot',
                'price' => '350000',
                'description' => 'SERANGAN PORT - HOTEL (Ubud / Tanah Lot)',
                'capacity' => '10',
                'luggage' => '5',
                'transmission' => 'Manual',
                'cover_image' => 'images/elf_short.jpg',
                'is_publish' => CarRental::READY,
                'car_owned' => '4',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Long Elf / Hiace',
                'price' => '450000',
                'description' => 'SERANGAN PORT - HOTEL (Ubud / Tanah Lot)',
                'capacity' => '14',
                'luggage' => '6',
                'transmission' => 'Manual',
                'cover_image' => 'images/hiace.png',
                'is_publish' => CarRental::READY,
                'car_owned' => '4',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Bus',
                'price' => '900000',
                'description' => 'SERANGAN PORT - HOTEL (Ubud / Tanah Lot)',
                'capacity' => '28',
                'luggage' => '20',
                'transmission' => 'Manual',
                'cover_image' => 'images/bus.png',
                'is_publish' => CarRental::READY,
                'car_owned' => '1',
            ],
            [
                'id' => Str::uuid(),
                'name' => 'Bus',
                'price' => '1000000',
                'description' => 'SERANGAN PORT - HOTEL (Ubud / Tanah Lot)',
                'capacity' => '35',
                'luggage' => '30',
                'transmission' => 'Manual',
                'cover_image' => 'images/bus.png',
                'is_publish' => CarRental::READY,
                'car_owned' => '1',
            ],
        ];

        CarRental::insert($cars);
    }

    public function tour_packages()
    {
        $packages = [
            [
                'name' => 'PENIDA DAY TOUR ( WEST )',
                'title' => 'PENIDA DAY TOUR ( WEST )',
                'body' => file_get_contents(__DIR__.'/packages/1.txt'),
                'meta_tag' => 'PENIDA DAY TOUR ( WEST )',
                'price' => '475000',
                'cover_image' => 'images/post4.webp',
                'is_publish' => TourPackage::PUBLISH,
                'prices' => [
                    [
                        'quantity' => 1,
                        'price' => 635000,
                    ],
                    [
                        'quantity' => 3,
                        'price' => 560000,
                    ],
                    [
                        'quantity' => 4,
                        'price' => 510000,
                    ],
                    [
                        'quantity' => 5,
                        'price' => 485000,
                    ],
                    [
                        'quantity' => 8,
                        'price' => 475000,
                    ],
                ],
            ],
            [
                'name' => 'PENIDA DAY TOUR ( EAST )',
                'title' => 'PENIDA DAY TOUR ( EAST )',
                'body' => file_get_contents(__DIR__.'/packages/2.txt'),
                'meta_tag' => 'PENIDA DAY TOUR ( EAST )',
                'price' => '475000',
                'cover_image' => 'images/post3.webp',
                'is_publish' => TourPackage::PUBLISH,
                'prices' => [
                    [
                        'quantity' => 1,
                        'price' => 635000,
                    ],
                    [
                        'quantity' => 3,
                        'price' => 560000,
                    ],
                    [
                        'quantity' => 4,
                        'price' => 510000,
                    ],
                    [
                        'quantity' => 5,
                        'price' => 485000,
                    ],
                    [
                        'quantity' => 8,
                        'price' => 475000,
                    ],
                ],
            ],
            [
                'name' => 'PENIDA DAY TOUR ( WEST - EAST )',
                'title' => 'PENIDA DAY TOUR ( WEST - EAST )',
                'body' => file_get_contents(__DIR__.'/packages/3.txt'),
                'meta_tag' => 'PENIDA DAY TOUR ( WEST - EAST )',
                'price' => '540000',
                'cover_image' => 'images/post3.webp',
                'is_publish' => TourPackage::PUBLISH,
                'prices' => [
                    [
                        'quantity' => 1,
                        'price' => 725000,
                    ],
                    [
                        'quantity' => 3,
                        'price' => 660000,
                    ],
                    [
                        'quantity' => 4,
                        'price' => 600000,
                    ],
                    [
                        'quantity' => 5,
                        'price' => 570000,
                    ],
                    [
                        'quantity' => 8,
                        'price' => 540000,
                    ],
                ],
            ],
            [
                'name' => 'PENIDA WEST TOUR - LEMBONGAN TOUR',
                'title' => 'PENIDA WEST TOUR - LEMBONGAN TOUR',
                'body' => file_get_contents(__DIR__.'/packages/4.txt'),
                'meta_tag' => 'PENIDA WEST TOUR - LEMBONGAN TOUR',
                'price' => '590000',
                'cover_image' => 'images/post2.webp',
                'is_publish' => TourPackage::PUBLISH,
                'prices' => [
                    [
                        'quantity' => 1,
                        'price' => 880000,
                    ],
                    [
                        'quantity' => 3,
                        'price' => 750000,
                    ],
                    [
                        'quantity' => 4,
                        'price' => 670000,
                    ],
                    [
                        'quantity' => 5,
                        'price' => 625000,
                    ],
                    [
                        'quantity' => 8,
                        'price' => 590000,
                    ],
                ],
            ],
            [
                'name' => 'PENIDA WEST TOUR - SNORKLING ( at QUICKSILVER MEGA PONTON)',
                'title' => 'PENIDA WEST TOUR - SNORKLING ( at QUICKSILVER MEGA PONTON)',
                'body' => file_get_contents(__DIR__.'/packages/5.txt'),
                'meta_tag' => 'PENIDA WEST TOUR - SNORKLING ( at QUICKSILVER MEGA PONTON)',
                'price' => '580000',
                'cover_image' => 'images/post1.webp',
                'is_publish' => TourPackage::PUBLISH,
                'prices' => [
                    [
                        'quantity' => 1,
                        'price' => 740000,
                    ],
                    [
                        'quantity' => 3,
                        'price' => 665000,
                    ],
                    [
                        'quantity' => 4,
                        'price' => 615000,
                    ],
                    [
                        'quantity' => 5,
                        'price' => 590000,
                    ],
                    [
                        'quantity' => 8,
                        'price' => 580000,
                    ],
                ],
            ],
            [
                'name' => 'LEMBONGAN ISLAND TOUR',
                'title' => 'LEMBONGAN ISLAND TOUR',
                'body' => file_get_contents(__DIR__.'/packages/6.txt'),
                'meta_tag' => 'LEMBONGAN ISLAND TOUR',
                'price' => '475000',
                'cover_image' => 'images/post1.webp',
                'is_publish' => TourPackage::PUBLISH,
                'prices' => [
                    [
                        'quantity' => 1,
                        'price' => 635000,
                    ],
                    [
                        'quantity' => 3,
                        'price' => 560000,
                    ],
                    [
                        'quantity' => 4,
                        'price' => 510000,
                    ],
                    [
                        'quantity' => 5,
                        'price' => 485000,
                    ],
                    [
                        'quantity' => 8,
                        'price' => 475000,
                    ],
                ],
            ],
        ];

        $images = collect();
        foreach (range(1, 4) as $img) {
            $images->add(File::create([
                'path' => 'images/post'.$img.'.webp',
            ]));
        }

        foreach ($packages as $pkg) {
            $package = TourPackage::create([
                'slug' => Str::slug($pkg['title']),
                'name' => $pkg['name'],
                'title' => $pkg['title'],
                'body' => $pkg['body'],
                'meta_tag' => $pkg['meta_tag'],
                'price' => $pkg['price'],
                'cover_image' => $pkg['cover_image'],
                'is_publish' => $pkg['is_publish'],
            ]);

            foreach ($pkg['prices'] as $price) {
                $package->prices()->create($price);
            }

            foreach ($images as $img) {
                $package->images()->create([
                    'file_id' => $img->id,
                ]);
            }
        }
    }
}
