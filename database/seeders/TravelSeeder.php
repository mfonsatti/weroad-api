<?php

namespace Database\Seeders;

use App\Models\Travel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $travels = [
            [
                'id' => 'd408be33-aa6a-4c73-a2c8-58a70ab2ba4d',
                'slug' => 'jordan-360',
                'name' => 'Jordan 360°',
                'description' => "Jordan 360°: the perfect tour to discover the suggestive Wadi Rum desert...",
                'startingDate' => '2021-11-01',
                'endingDate' => '2021-11-09',
                'price' => 199900,
                'moods' => [
                    'nature' => 80,
                    'relax' => 20,
                    'history' => 90,
                    'culture' => 30,
                    'party' => 10,
                ]
            ],
            [
                'id' => '4f4bd032-e7d4-402a-bdf6-aaf6be240d53',
                'slug' => 'iceland-hunting-northern-lights',
                'name' => 'Iceland: hunting for the Northern Lights',
                'description' => "Why visit Iceland in winter? Because it is between October and March...",
                'startingDate' => '2021-11-01',
                'endingDate' => '2021-11-08',
                'price' => 199900,
                'moods' => [
                    'nature' => 100,
                    'relax' => 30,
                    'history' => 10,
                    'culture' => 20,
                    'party' => 10,
                ]
            ],
            [
                'id' => 'cbf304ae-a335-43fa-9e56-811612dcb601',
                'slug' => 'united-arab-emirates',
                'name' => 'United Arab Emirates: from Dubai to Abu Dhabi',
                'description' => "At Dubai and Abu Dhabi everything is huge and majestic...",
                'startingDate' => '2022-01-03',
                'endingDate' => '2022-01-10',
                'price' => 149900,
                'moods' => [
                    'nature' => 30,
                    'relax' => 40,
                    'history' => 20,
                    'culture' => 80,
                    'party' => 70,
                ]
            ]
        ];

        foreach ($travels as $travel) {
            Travel::create($travel);
        }
    }
}
