<?php

namespace App\Services;

use App\Models\Category;

class CategoryService extends Service
{
    public function get($params = [])
    {
        $model = new Category();
        if (isset($params['name']) && ! empty($params['name'])) {
            $params['name'] = trim($params['name']);
            $model = $model->where('name', 'like', "%". strip_tags($params['name']) ."%");
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

    public function save($params, $id = 0)
    {
        $results = null;
        $id = intval($id);
        $data['name'] = trim(strip_tags($params['name']));
        $data['url'] = trim(strip_tags($params['url']));

        if ($id > 0) {
            $results = Category::where('id', $id)->update($data);
        } else {
            $results =  Category::insertGetId($data);
        }

        return $results;
    }

    public function getOne($id)
    {
        $results = [];
        if (intval($id) > 0) {
            $results = Category::where('id', intval($id))->first();
        }
        if (! empty($results)) {
            $results = $results->toArray();
        }

        return $results;
    }

    public function formatter($rows)
    {

        return $rows;
    }
}