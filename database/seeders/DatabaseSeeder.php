<?php

namespace Database\Seeders;

use App\Models\Todo;
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
        Todo::unsetEventDispatcher();
        
        $this->call([
            UserSeeder::class,
            TodoSeeder::class
        ]);
    }
}
