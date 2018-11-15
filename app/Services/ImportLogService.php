<?php

namespace App\Services;

use App\Models\Book;
use App\Models\ImportLog;

class ImportLogService extends Service
{
    public function get($params = [])
    {
        $model = new ImportLog();
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

    public function getOne($id)
    {
        $results = [];
        if (intval($id) > 0) {
            $results = ImportLog::where('id', intval($id))->first();
        }
        if (! empty($results)) {
            $results = $results->toArray();
        }

        return $results;
    }

    public function getImportBook($content)
    {
        $results = [];
        $content = json_decode($content, true);
        $books = Book::whereIn('id', $content)
            ->select(['id', 'title', 'author', 'category_id', 'unique_code'])
            ->get();
        if (! empty($books)) {
            $books = $books->toArray();
            foreach ($books as $v) {
                $results[$v['category_id']] = $v;
            }
        }

        return $results;
    }

    public function delete($id)
    {
        return ImportLog::destroy($id);
    }

    public function formatter($rows)
    {

        return $rows;
    }
}