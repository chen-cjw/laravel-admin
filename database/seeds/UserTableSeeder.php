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
        for ($i=0;$i<100;$i++) {
            \App\User::create([
                'name'=>'chen'.$i,
                'phone'=>'183617715'.$i,
                'weapp_openid'=>'xxxxxxxxxxxx'.$i,
                'weixin_session_key'=>'xxxxxxxxxxxx'.$i,
                'password'=>bcrypt(123123),
            ]);
        }

    }
}
