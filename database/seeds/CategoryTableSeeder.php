<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            [
                'id' => '1',
                'name' => '玄幻奇幻',
                'url' => 'https://www.xbiquge6.com/xclass/1/1.html'
            ],
            [
                'id' => '2',
                'name' => '武侠仙侠',
                'url' => 'https://www.xbiquge6.com/xclass/2/1.html'
            ],
            [
                'id' => '3',
                'name' => '都市言情',
                'url' => 'https://www.xbiquge6.com/xclass/3/1.html'
            ],
            [
                'id' => '4',
                'name' => '历史军事',
                'url' => 'https://www.xbiquge6.com/xclass/4/1.html'
            ],
            [
                'id' => '5',
                'name' => '科幻灵异',
                'url' => 'https://www.xbiquge6.com/xclass/5/1.html'
            ],
            [
                'id' => '6',
                'name' => '网游竞技',
                'url' => 'https://www.xbiquge6.com/xclass/6/1.html'
            ],
            [
                'id' => '7',
                'name' => '女频频道',
                'url' => 'https://www.xbiquge6.com/xclass/7/1.html'
            ]
        ];

        App\Models\Category::truncate();
        foreach ($category as $v) {
            \App\Models\Category::insert($v);
        }
    }
}
