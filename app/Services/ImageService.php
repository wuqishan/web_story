<?php

namespace App\Services;

class ImageService extends Service
{
    public function get($params = [])
    {
        $model = new Book();
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
        if (! empty($params['sort'])) {
            $model = $model->orderBy($params['sort'][0], $params['sort'][1]);
        }

        $results['list'] = [];
        $results['length'] = $this->_length;
        $results['page'] = $this->_page;
        $results['offset'] = $this->_offset;
        $results['total'] = $model->count();
        $dataModel = $model->offset($this->_offset)->limit($this->_length)->get();
        if (! empty($dataModel)) {
            $results['list'] = $dataModel->toArray();
        }
        $results['list'] = $this->formatter($results['list']);

        return $results;
    }
}