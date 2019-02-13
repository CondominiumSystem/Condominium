<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::Table('permissions')->delete();
      $permissions=[
          array(
              'name' => 'create-auth-persons',
              'display_name'=>'Create Auth Persons',
              'description'=>'Create Auth Persons',
              'created_at'=>date("Y-m-d H:i:s")
          ),
          array(
              'name' => 'delete-auth-persons',
              'display_name'=>'Delete Auth Persons',
              'description'=>'Delete Auth Persons',
              'created_at'=>date("Y-m-d H:i:s")
          ),
          array(
              'name' => 'edit-auth-persons',
              'display_name'=>'Edit Auth Persons',
              'description'=>'Edit Auth Persons',
              'created_at'=>date("Y-m-d H:i:s")
          ),

      ];
      DB::Table('permissions')->insert($permissions);
    }
}
