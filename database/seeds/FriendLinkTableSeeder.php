<?php

use Illuminate\Database\Seeder;

class FriendLinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\FriendLink::truncate();
        $friend_link =  [
            'title' => '新笔趣阁',
            'link' => 'https://www.xbiquge6.com/',
            'description' => '小说网站',
            'deleted' => 0,
            'orderby' => 0
        ];
        \App\Models\FriendLink::insert($friend_link);
    }
}
