<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\ChapterContent;
use Illuminate\Support\Facades\DB;

class ChapterService extends Service
{
    public function get($book_unique_code, $category_id, $params = [])
    {
        $model = new Chapter();
        $model = $model->setTable($category_id);
        $model = $model->where('book_unique_code', trim($book_unique_code));
        if (isset($params['lte_number_of_words']) && intval($params['lte_number_of_words']) > 0) {
            $model = $model->where('number_of_words', '<=', intval($params['lte_number_of_words']));
        }
        if (isset($params['gte_number_of_words']) && intval($params['gte_number_of_words']) > 0) {
            $model = $model->where('number_of_words', '>=', intval($params['gte_number_of_words']));
        }
        if (isset($params['title']) && ! empty($params['title'])) {
            $params['title'] = trim($params['title']);
            $model = $model->where('title', 'like', "%". strip_tags($params['title']) ."%");
        }

        if (isset($params['sort']) && ! empty($params['sort'])) {
            $model = $model->orderBy($params['sort'][0], $params['sort'][1]);
        } else {
            $model = $model->orderBy('orderby', 'asc');
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

    public function getOne($params, $withContent = false)
    {
        $chapter = [];
        $category_id = intval($params['category_id']);
        $chapterModel = new Chapter();
        $chapterModel = $chapterModel->setTable($category_id);

        $chapterContentModel = new ChapterContent();
        $chapterContentModel = $chapterContentModel->setTable($category_id);

        if (isset($params['id']) && intval($params['id']) > 0) {
            $chapter = $chapterModel->where('id', intval($params['id']))->first()->toArray();
        }
        if (isset($params['unique_code'])) {
            $chapter = $chapterModel->where('unique_code', $params['unique_code'])->first()->toArray();
        }

        if (! empty($chapter) && $withContent) {
            $chapterContent = $chapterContentModel->where('id', $chapter['id'])->first()->toArray();
            $chapter['content'] = $chapterContent['content'];
        }

        return (array) $chapter;
    }

    public function save($params)
    {
        $results = true;
        $id = intval($params['id']);
        $category_id = intval($params['category_id']);

        $chapterModel = new Chapter();
        $chapterModel = $chapterModel->setTable($category_id);

        if (
            isset($params['field']) && ! empty($params['field'])
        ) {
            $field = trim($params['field']);
            $value = (string) trim($params['value']);

            $results = $chapterModel->where('id', $id)->update([$field => $value]);
        }

        return $results;
    }

    public function deleteAllChpater($params)
    {
        $book_unique_code = trim($params['book_unique_code']);
        $category_id = intval($params['category_id']);

        if (! empty($book_unique_code) && $category_id > 0) {

            Book::where('unique_code', $book_unique_code)->update(['newest_chapter' => '']);

            $ids = DB::table('chapter_' . $category_id)
                ->where('book_unique_code', $book_unique_code)
                ->select(['id'])
                ->get()
                ->toArray();

            $ids = array_column($ids, 'id');

            DB::table('chapter_' . $category_id)
                ->whereIn('id', $ids)
                ->delete();

            DB::table('chapter_content_' . $category_id)
                ->whereIn('id', $ids)
                ->delete();
        }

        return true;
    }

    /**
     * @param $id
     * @param integer $category_id
     * @param integer $v
     * @return mixed
     */
    public function updateView($id, $category_id, $v = 1)
    {
        $chapterModel = new Chapter();
        $chapterModel = $chapterModel->setTable($category_id);

        return $chapterModel->where('id', $id)->increment('view', $v);
    }

    public function updateNumberOfWords($id, $category_id, $number_of_words)
    {
        $chapterModel = new Chapter();
        $chapterModel = $chapterModel->setTable($category_id);

        return $chapterModel->where('id', $id)->update(['number_of_words' => $number_of_words]);
    }

    public function formatter($chapter)
    {
        return $chapter;
    }
}