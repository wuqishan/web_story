<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Category;
use App\Models\ImportLog;
use Illuminate\Support\Facades\DB;

class ImportLogService extends Service
{
    public function get($params = [])
    {
        $model = new ImportLog();
        if (isset($params['name']) && ! empty($params['name'])) {
            $params['name'] = trim($params['name']);
            $model = $model->where('name', 'like', "%". strip_tags($params['name']) ."%");
        }

        if (isset($params['sort'])) {
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

    public function getImportChapter($content)
    {
        $results = [];
        $content = json_decode($content, true);
        foreach ($content as $k => $v) {
            $chapters = DB::table('chapter_' . $k . ' as c')
                ->leftJoin('book' , 'book.unique_code', '=','c.book_unique_code')
                ->whereIn('c.id', $v)
                ->orderBy('c.book_unique_code', 'asc')
                ->orderBy('c.orderby', 'asc')
                ->select(['book.title as book_title', 'c.title', 'c.category_id'])
                ->get()
                ->toArray();
            $results = array_merge($chapters, $results);
        }
        $results = array_map(function($v) {return (array) $v;}, $results);

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