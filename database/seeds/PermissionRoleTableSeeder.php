<?php

use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::Table('permission_role')->delete();
      $permissionRole=[
          array(
              'permission_id' => '1',
              'role_id'=>'1',

          ),
          array(
              'permission_id' => '2',
              'role_id'=>'1',

          ),
          array(
            'permission_id' => '3',
            'role_id'=>'1',

          ),
          array(
            'permission_id' => '4',
            'role_id'=>'1',

          ),

      ];
      DB::Table('permission_role')->insert($permissionRole);
    }
}
