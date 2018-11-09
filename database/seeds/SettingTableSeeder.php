<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\Setting::truncate();
        $setting =  [
            [
                'name' => 'seo.title',
                'value' => '有趣的灵魂中文小说网',
                'orderby' => 1
            ],
            [
                'name' => 'seo.keywords',
                'value' => '各种类型的小说，玄幻奇幻，武侠仙侠，都市言情，历史军事，科幻灵异，网游竞技，女频频道',
                'orderby' => 2
            ],
            [
                'name' => 'seo.description',
                'value' => '各种类型的小说，热血，奇异，幽默等各种需求都可满足于你',
                'orderby' => 3
            ]
        ];
        \App\Models\Setting::insert($setting);
    }
}
