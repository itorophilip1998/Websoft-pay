<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // check if table users is empty
       if(DB::table('roles')->get()->count() == 0){ 
        DB::table('roles')->insert([ 
            [
                'name' => 'Super-admin',
                'status' => 'full access to the app', 
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'name' => 'Admin',
                'status' => 'midium access to the app',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'status' => 'normal access to the app',
                'created_at' => now(),
                'updated_at' => now(),
            ], 
        ]);

    } else {
         echo "\e[31mTable is not empty, therefore NOT ";
         }

    }
}
