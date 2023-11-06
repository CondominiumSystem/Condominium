<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class FinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('fines')->delete();
        $fines=[
            array(
                'value' => 10,
                'description'=>'Multa por minga',
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'value' => 10,
                'description'=>'Multa por no asistencia sesión',
                'created_at'=>date("Y-m-d H:i:s")
            ),
        ];
        DB::Table('fines')->insert($fines);
    }
}
