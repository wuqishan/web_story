<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookDeleted;
use App\Services\Spider\SubSpiderService;
use Illuminate\Support\Facades\DB;

class BookService extends Service
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

    public function getOne($params)
    {
        $book = [];
        if (isset($params['book_id']) && intval($params['book_id']) > 0) {
            $book = Book::where('id', intval($params['book_id']))->first()->toArray();
        }
        if (isset($params['unique_code'])) {
            $book = Book::where('unique_code', $params['unique_code'])->first()->toArray();
        }
        $book = $this->formatter($book, false);

        return (array) $book;
    }

    public function save($params, $id = 0)
    {
        $results = null;
        $id = intval($id);

        if ($id > 0) {
            $data['view'] = intval($params['view']);
            $data['newest_chapter'] = empty($params['newest_chapter']) ? '' : trim($params['newest_chapter']);
            $data['finished'] = intval($params['finished']);
            $data['image_origin_url'] = trim($params['image_origin_url']);
            $results = Book::where('id', $id)->update($data);
        } else {
            $data['url'] = trim($params['url']);
            $data['category_id'] = intval($params['category_id']);
            $service = new SubSpiderService();
            $results = $service->getBook($data['url'], $data['category_id']);
        }

        return $results;
    }

    public function updateView($id, $v = 1)
    {
        return Book::where('id', $id)->increment('view', $v);
    }

    public function updateFinished($id, $finished)
    {
        return Book::where('id', $id)->update(['finished' => $finished]);
    }

    /**
     * 删除书本
     *
     * @param $book_id
     * @return bool
     */
    public function deleteBook($book_id)
    {
        $results = true;
        $book = Book::find($book_id);
        if (empty($book)) {
            $results = false;
        } else {
            $book = $book->toArray();
            DB::beginTransaction();
            $del_book_status = (bool) Book::destroy($book_id);
            $del_chapter_status = (bool) DB::table('chapter_' . $book['category_id'])
                ->where('book_unique_code', $book['unique_code'])
                ->delete();

            unset($book['id']);
            $add_book_delete = (bool) BookDeleted::insertGetId($book);
            if ($del_book_status && $del_chapter_status && $add_book_delete) {
                DB::commit();
            } else {
                DB::rollBack();
                $results = false;
            }
        }

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