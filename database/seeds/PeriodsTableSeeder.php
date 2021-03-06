<?php

use Illuminate\Database\Seeder;

class PeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DB::Table('periods')->delete();


        $years = [2010,2011,2012,2013,2014,2015];
        $months = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];

        $periods=[];
        foreach ($years as $year) {
            $index = 1;
            foreach ($months as $month) {
                array_push(
                    $periods,
                    array(
                        'year'=> $year,
                        'month_id' => $index, 'month_name' => $months[$index-1],
                        'created_at'=>date("Y-m-d H:i:s")
                    )
                );
                $index++;
            }
        }
        DB::Table('periods')->insert($periods);
    }
}
