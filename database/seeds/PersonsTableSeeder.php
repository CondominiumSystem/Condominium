<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::Table('persons')->delete();
         factory(App\Person::class)->times(250)->create();

    }
}
