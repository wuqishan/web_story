<?php

namespace App\Services;

use App\Models\Chapter;
use App\Models\CheckBookInfo;

class CheckBookInfoService extends Service
{
    public function get($params = [])
    {
        $model = new CheckBookInfo();
        if (isset($params['book_category_id']) && intval($params['book_category_id']) > 0) {
            $model = $model->where('book_category_id', intval($params['book_category_id']));
        }
        if (isset($params['book_title']) && ! empty($params['book_title'])) {
            $params['book_title'] = trim($params['book_title']);
            $model = $model->where('book_title', 'like', "%". strip_tags($params['book_title']) ."%");
        }
        if (isset($params['status']) && intval($params['status']) > 0) {
            $model = $model->where('status', intval($params['status']));
        }
        if (isset($params['book_id']) && intval($params['book_id']) > 0) {
            $model = $model->where('book_id', intval($params['book_id']));
        }
        if (! empty($params['sort'])) {
            $model = $model->orderBy($params['sort'][0], $params['sort'][1]);
        } else {
            $model = $model->orderBy('id', 'desc');
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

    public function getOne($id)
    {
        $checkBookInfo = [];
        if (intval($id) > 0) {
            $checkBookInfo = CheckBookInfo::where('id', intval($id))->first()->toArray();
        }
        
        return (array) $checkBookInfo;
    }

    public function update($id, $field, $val)
    {
        if (! is_array($id)) {
            $id = [$id];
        }
        $results = CheckBookInfo::whereIn('id', $id)
            ->update([$field => $val]);

        return (bool) $results;
    }

    public function delete($id)
    {
        return CheckBookInfo::destroy($id);
    }

    public function formatter($data)
    {
//        if (! empty($data)) {
//
//        }

        return $data;
    }
}