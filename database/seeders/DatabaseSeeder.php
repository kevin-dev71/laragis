<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $user = User::factory()->create([
      'name' => 'Kevin',
      'email' => 'test@test.com',
    ]);
    Listing::create([
      'title' => 'Laravel Senior Developer',
      'tags' => 'laravel, javascript',
      'company' => 'Acme Corp',
      'location' => 'Boston, MA',
      'email' => 'email1@email.com',
      'website' => 'https://www.acme.com',
      'description' =>
        'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam minima et illo reprehenderit quas possimus voluptas repudiandae cum expedita, eveniet aliquid, quam illum quaerat consequatur! Expedita ab consectetur tenetur delensiti?',
      'user_id' => $user->id,
    ]);
    Listing::create([
      'title' => 'Full-Stack Engineer',
      'tags' => 'laravel, backend ,api',
      'company' => 'Stark Industries',
      'location' => 'New York, NY',
      'email' => 'email2@email.com',
      'website' => 'https://www.starkindustries.com',
      'description' =>
        'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam minima et illo reprehenderit quas possimus voluptas repudiandae cum expedita, eveniet aliquid, quam illum quaerat consequatur! Expedita ab consectetur tenetur delensiti?',
      'user_id' => $user->id,
    ]);
  }
}
