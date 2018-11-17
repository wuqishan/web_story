<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Admin::truncate();
        $user =  [
            'username' => 'wuqishan',
            'password' => '92b655398726e48e6972506817dc9e82',   // wuqishan 的 md5
            'status' => 0
        ];
        \App\Models\Admin::insert($user);
    }
}
