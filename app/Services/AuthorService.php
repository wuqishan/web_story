<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class AuthorService extends Service
{
    public function get($params = [])
    {
        $model = new Author();

        if (isset($params['name']) && ! empty($params['name'])) {
            $params['name'] = trim($params['name']);
            $model = $model->where('author.name', 'like', "%". strip_tags($params['name']) ."%");
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

        if ($id > 0) {
            $results = Author::where('id', $id)->update($data);
        } else {
            $results =  Author::insertGetId($data);
        }

        return true;
//        return $results;
    }

    public function getOne($id)
    {
        $results = [];
        if (intval($id) > 0) {
            $results = Author::where('id', intval($id))->first();
        }
        if (! empty($results)) {
            $results = $results->toArray();
        }

        return $results;
    }

    public function delete($id)
    {
        return Author::destroy($id);
    }

    public function formatter($rows)
    {
        foreach ($rows as $k => $v) {
            $rows[$k]['book_number'] = Book::where('author_id', $v['id'])->count();
        }

        return $rows;
    }
}