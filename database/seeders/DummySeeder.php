<?php

namespace Database\Seeders;

use App\Models\FastboatPlace;
use App\Models\Setting;
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
}
