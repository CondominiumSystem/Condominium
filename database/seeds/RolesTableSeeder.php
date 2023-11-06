<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('roles')->delete();
        $roles=[
            array(
                'name' => 'admin',
                'display_name'=>'Administrador',
                'description'=>'administrador del sistema',
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'name' => 'manager',
                'display_name'=>'Gerente',
                'description'=>'Gerente de la Empresa',
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'name' => 'accountant',
                'display_name'=>'Contador',
                'description'=>'Contador de la empresa',
                'created_at'=>date("Y-m-d H:i:s")
            ),
            array(
                'name' => 'treasurer',
                'display_name'=>'Tesorero',
                'description'=>'Tesorero de la empresa',
                'created_at'=>date("Y-m-d H:i:s")
            ),
        ];
        DB::Table('roles')->insert($roles);

    }
}
