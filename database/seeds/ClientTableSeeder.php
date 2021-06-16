<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dateNow = date('Y-m-d H:i:s');
        $client=[
            [
                'client_name'=>'Mega Cool',
                'client_image'=>'/client_image/LOGO MEGACOOLS_DEFAULT.png',
                'client_slug'=>\Str::slug('Mega Cool','-'),
                'company_name'=>'CV. Mega Cool',
                'email'=>'megacool@gmail.com',
                'phone_whatsapp'=>'6281288222777',
                'phone'=>'‭021777000',
                'client_address'=>'Jakarta Barat',
                'created_at'=>$dateNow,
                'updated_at'=>$dateNow
            ],
            [
                'client_name'=>'Mega Pro',
                'client_image'=>'/client_image/mega_pro.jpg',
                'client_slug'=>\Str::slug('Mega Pro','-'),
                'company_name'=>'CV. Mega Pro',
                'email'=>'megapro@gmail.com',
                'phone_whatsapp'=>'6281288111666',
                'phone'=>'‭021333444',
                'client_address'=>'Jakarta Barat',
                'created_at'=>$dateNow,
                'updated_at'=>$dateNow
            ]
        ];

         
        DB::table('b2b_client')->insert($client);
    }
}
