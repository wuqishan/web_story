<?php

namespace App\Services;


use App\Models\Book;
use App\Models\Category;

class DashboardService extends Service
{
    public function getBooks($params = [])
    {
        $results = Book::all(['title', 'author', 'unique_code', 'finished', 'category_id', 'author_id', 'view', 'last_update'])->toArray();

        $grout_by_finished = [
            'yes' => ['name' => '完本', 'value' => 0],
            'no' => ['name' => '未完本', 'value' => 0],
        ];
        $grout_by_cagtegory_id = [];
        $max_view_5 = [];

        foreach ($results as $v) {
            if ($v['finished'] == 0) {
                $grout_by_finished['no']['value']++;
            } else {
                $grout_by_finished['yes']['value']++;
            }

            if (isset($grout_by_cagtegory_id[$v['category_id']])) {
                $grout_by_cagtegory_id[$v['category_id']]['value']++;
            } else {
                $grout_by_cagtegory_id[$v['category_id']]['value'] = 1;
                $grout_by_cagtegory_id[$v['category_id']]['name'] = Category::categoryMap($v['category_id']);
            }
        }
        array_multisort(array_column($results, 'view'),SORT_DESC,$results);
        $max_view_5 = array_slice($results, 0, 5);

        return [
            'group_by_category' => array_values($grout_by_cagtegory_id),
            'group_by_finished' => array_values($grout_by_finished),
            'max_view_5' => $max_view_5
        ];
    }
}