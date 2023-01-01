<?php

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
        $this->call([
            /** One time */
            // UserSeeder::class,
            /** any times */
            ClassTypeSeeder::class,
        ]);
    }
}
