<?php

use Illuminate\Database\Seeder;

class AliquotValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('aliquot_values')->delete();
        $aliquotValues=[
            array(
                'value' => 10,
                'start_date'=>date("Y-m-d H:i:s"),
                'end_date'=>date("Y-m-d H:i:s"),
                'property_type_id'=>1,
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'value' => 5,
                'start_date'=>date("Y-m-d H:i:s"),
                'end_date'=>date("Y-m-d H:i:s"),
                'property_type_id'=>2,
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'value' => 8,
                'start_date'=>date("Y-m-d H:i:s"),
                'end_date'=>date("Y-m-d H:i:s"),
                'property_type_id'=>3,
                'created_at'=>date("Y-m-d H:i:s")
            ),

        ];
        DB::Table('aliquot_values')->insert($aliquotValues);

    }
}
