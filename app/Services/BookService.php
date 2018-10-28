<?php

namespace App\Services;

use App\Models\Book;

class BookService extends Service
{
    public function get($params, $sort = [], $limit = 0)
    {
        $results['length'] = $this->_length;
        $results['list'] = [];

        $model = new Book();
        if (isset($params['category_id']) && intval($params['category_id']) > 0) {
            $model = $model->where('category_id', intval($params['category_id']));
        }
        if (! empty($params['sort'])) {
            $model = $model->orderBy($sort[0], $sort[1]);
        }

        if (intval($limit) > 0) {
            $model = $model->limit(intval($limit));
        }

        $books = $model->get();
        if (! empty($books)) {
            $books = $books->toArray();
        }
        $books = $this->formatter((array) $books);
        return (array) $books;
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

    public function updateView($id, $v = 1)
    {
        return Book::where('id', $id)->increment('view', $v);
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