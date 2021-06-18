<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = date('Y-m-d H:i:s');
        $user=[
            [
                'client_id'=>1,
                'name'=>'Admin Sudahonline',
                'email'=>'admin@sudahonline.com',
                'password'=>\Hash::make('admin'),
                'roles'=>'OWNER',
                'created_at'=>$dateNow,
                'updated_at'=>$dateNow
            ],
        ];

         
        DB::table('users')->insert($user);
    }
}
