<?php

namespace App\Services;

use App\Models\FriendLink;

class FriendLinkService extends Service
{
    public function get($params = [])
    {
        $model = new FriendLink();
        if (isset($params['title']) && ! empty($params['title'])) {
            $params['title'] = trim($params['title']);
            $model = $model->where('title', 'like', "%". strip_tags($params['title']) ."%");
        }

        if (isset($params['deleted']) && intval($params['deleted']) > 0) {
            $model = $model->where('deleted', intval($params['deleted']));
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
        $data['title'] = trim(strip_tags($params['title']));
        $data['link'] = trim(strip_tags($params['link']));
        $data['description'] = trim(strip_tags($params['description']));
        $data['deleted'] = intval($params['deleted']);
        $data['orderby'] = intval($params['orderby']);

        if ($id > 0) {
            $results = FriendLink::where('id', $id)->update($data);
        } else {
            $results =  FriendLink::insertGetId($data);
        }

        return $results;
    }

    public function getOne($id)
    {
        $results = [];
        if (intval($id) > 0) {
            $results = FriendLink::where('id', intval($id))->first();
        }
        if (! empty($results)) {
            $results = $results->toArray();
        }

        return $results;
    }

    public function delete($id)
    {
        return FriendLink::destroy($id);
    }

    public function formatter($rows)
    {

        return $rows;
    }
}