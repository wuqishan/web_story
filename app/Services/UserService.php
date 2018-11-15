<?php

namespace App\Services;

use App\Helper\ToolsHelper;
use App\Models\User;

class UserService extends Service
{
    public function get($params = [])
    {
        $model = new User();
        if (isset($params['username']) && ! empty($params['username'])) {
            $params['username'] = trim($params['username']);
            $model = $model->where(function ($query) use ($params) {
                $query->orWhere('username', 'like', "%". strip_tags($params['username']) ."%");
                $query->orWhere('nickname', 'like', "%". strip_tags($params['username']) ."%");
                $query->orWhere('email', 'like', "%". strip_tags($params['username']) ."%");
            });
        }
        if (isset($params['status']) && intval($params['status']) > 0) {
            $model = $model->where('status', intval($params['status']));
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

        $data['username'] = trim(strip_tags($params['username']));
        $data['nickname'] = trim(strip_tags($params['nickname']));
        $data['email'] = trim(strip_tags($params['email']));
        $data['status'] = intval($params['status']) > 0 ? intval($params['status']) : 1;

        if ($id > 0) {
            $results = User::where('id', $id)->update($data);
        } else {
            $data['salt'] = ToolsHelper::getSalt(8);
            $data['password'] = ToolsHelper::encodePassword(trim($params['password']), $data['salt']);
            $results =  User::insertGetId($data);
        }

        return $results;
    }

    public function getOne($id)
    {
        $results = [];
        if (intval($id) > 0) {
            $results = User::where('id', intval($id))->first();
        }
        if (! empty($results)) {
            $results = $results->toArray();
        }

        return $results;
    }

    public function delete($id)
    {
        return User::destroy($id);
    }

    public function formatter($rows)
    {

        return $rows;
    }
}