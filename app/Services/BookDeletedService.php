<?php

namespace App\Services;

use App\Models\BookDeleted;

class BookDeletedService extends Service
{
    public function get($params = [])
    {
        $model = new BookDeleted();
        if (isset($params['category_id']) && intval($params['category_id']) > 0) {
            $model = $model->where('category_id', intval($params['category_id']));
        }
        if (isset($params['title']) && ! empty($params['title'])) {
            $params['title'] = trim($params['title']);
            $model = $model->where('title', 'like', "%". strip_tags($params['title']) ."%");
        }
        if (isset($params['finished']) && intval($params['finished']) > 0) {
            $model = $model->where('finished', intval($params['finished']));
        }
        if (isset($params['author_id']) && intval($params['author_id']) > 0) {
            $model = $model->where('author_id', intval($params['author_id']));
        }
        if (isset($params['last_update_start']) && ! empty($params['last_update_start'])) {
            $params['last_update_start'] = strtotime($params['last_update_start']);
            $params['last_update_start'] = date('Y-m-d H:i:s', $params['last_update_start']);
            $model = $model->where('last_update', '>=', trim($params['last_update_start']));
        }
        if (isset($params['last_update_end']) && ! empty($params['last_update_end'])) {
            $params['last_update_end'] .= ' 23:59:59';
            $model = $model->where('last_update', '<=', trim($params['last_update_end']));
        }
        if (! empty($params['sort'])) {
            $model = $model->orderBy($params['sort'][0], $params['sort'][1]);
        } else {
            $model = $model->orderBy('id', 'desc');
        }

        $results['list'] = [];
        $results = $this->pageInit($results, $params);  // 重写分页信息
        $results['total'] = $model->count();

        $dataModel = $model->offset($this->_offset)->limit($this->_length)->get();
        if (! empty($dataModel)) {
            $results['list'] = $dataModel->toArray();
        }
        $results['list'] = $this->formatter($results['list']);

        return $results;
    }

    public function formatter($books, $flag = true)
    {
        $defaultImg = '/book/author/images/default.jpg';
        if (! empty($books)) {
            if ($flag) {
                foreach ($books as $k => $v) {
                    if (empty($v['image_local_url'])) {
                        $v['image_local_url'] = $defaultImg;
                    }
                    $v['description'] = strip_tags($v['description']);
                    $books[$k] = $v;
                }
            } else {
                if (empty($books['image_local_url'])) {
                    $books['image_local_url'] = $defaultImg;
                }
                $books['description'] = strip_tags($books['description']);
            }
        }

        return $books;
    }
}