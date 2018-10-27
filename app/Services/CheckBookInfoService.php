<?php

namespace App\Services;

use App\Models\Chapter;
use App\Models\CheckBookInfo;

class CheckBookInfoService extends Service
{
    public function get($params, $sort = [], $limit = 0, $select = [])
    {
        $mode = new CheckBookInfo();
        if (isset($params['book_id'])) {
            $mode = $mode->where('book_id', intval($params['book_id']));
        }
        if (isset($params['status'])) {
            $mode = $mode->where('status', intval($params['status']));
        }
        if (! empty($sort)) {
            $mode = $mode->orderBy($sort[0], $sort[1]);
        }

        if (! empty($select) > 0) {
            $mode = $mode->select($select);
        }

        $data = $mode->get();
        if (! empty($data)) {
            $data = $data->toArray();
        }
        $data = $this->formatter((array) $data);

        return (array) $data;
    }

    public function getOne($params)
    {
        $checkBookInfo = [];
        if (isset($params['id']) && intval($params['id']) > 0) {
            $checkBookInfo = CheckBookInfo::where('id', intval($params['id']))->first()->toArray();
        }
        
        return (array) $checkBookInfo;
    }

    public function update($id, $field, $val)
    {
        $results = CheckBookInfo::where('id', $id)
            ->update([$field => $val]);

        return (bool) $results;
    }

    public function formatter($data)
    {
        if (! empty($data)) {

        }

        return $data;
    }
}