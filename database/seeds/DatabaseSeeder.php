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
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(FinesTableSeeder::class);
        $this->call(PeriodsTableSeeder::class);
        $this->call(PropertyTypesTableSeeder::class);
        $this->call(PersonTypesTableSeeder::class);
        $this->call(PersonsTableSeeder::class);
        $this->call(AliquotValuesTableSeeder::class);

    }
}
