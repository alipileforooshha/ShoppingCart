<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //make 1 manager
        User::factory(1)->create([
            'type' => 1,
            'email' => 'micahelwwww@gmail.com'
        ]);
    }
}
