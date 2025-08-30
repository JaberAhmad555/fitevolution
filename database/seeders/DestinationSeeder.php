<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destination;

class DestinationSeeder extends Seeder
{
    public function run(): void
    {
        Destination::create([
            'name' => 'Mountain Trail Marathon',
            'location' => 'Chamonix, France',
            'description' => 'Experience breathtaking alpine scenery by participating in world-famous trail running events.',
            'fitness_type' => 'running',
            'image_path' => 'destinations/chamonix.jpg',
        ]);

        Destination::create([
            'name' => 'Coastal Cycling Tour',
            'location' => 'Big Sur, California, USA',
            'description' => 'Cycle along one of the world\'s most scenic coastlines, with dramatic cliffs and ocean views.',
            'fitness_type' => 'cycling',
            'image_path' => 'destinations/big_sur.jpg',
        ]);

        Destination::create([
            'name' => 'Weightlifting & Strongman Camp',
            'location' => 'Reykjavík, Iceland',
            'description' => 'Train in the land of giants. Join an intensive lifting camp inspired by Iceland\'s strongman heritage.',
            'fitness_type' => 'weightlifting',
            'image_path' => 'destinations/iceland.jpg',
        ]);
        
        Destination::create([
            'name' => 'Yoga & Wellness Retreat',
            'location' => 'Ubud, Bali, Indonesia',
            'description' => 'Find your balance with daily yoga, meditation, and healthy organic food in a tranquil paradise.',
            'fitness_type' => 'yoga', // A new type for variety
            'image_path' => 'destinations/bali.jpg',
        ]);
    }
}
