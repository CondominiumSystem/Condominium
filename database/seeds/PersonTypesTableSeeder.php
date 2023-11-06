<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PersonTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
     {
         DB::Table('person_types')->delete();
         $person_types=[
             array(
                 'name' => 'Propietario',
             ),
             array(
                 'name' => 'Arrendatario',
             ),
         ];
         DB::Table('person_types')->insert($person_types);

     }

}
