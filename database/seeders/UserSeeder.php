<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try{
            if(DB::table('users')->count() == 0){

                DB::table('users')->insert([

                    [   'name'       => 'Super Admin',
                        'email'      => 'admin@admin.com',
                        'password'   => Hash::make('password'),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                   

                ]);
                
            } else { echo "<br>[user Table is not empty] "; }

        }catch(Exception $e) {
            echo $e->getMessage();
        }
    
    }
}
