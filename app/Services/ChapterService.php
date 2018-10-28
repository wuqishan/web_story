<?php

namespace App\Services;

use App\Models\Chapter;
use App\Models\ChapterContent;

class ChapterService extends Service
{
    public function get($params, $sort = [], $limit = 0, $select = [])
    {
        $chapterModel = new Chapter();
        $chapterModel = $chapterModel->setTable($params['category_id']);

        if (isset($params['book_unique_code'])) {
            $chapterModel = $chapterModel->where('book_unique_code', $params['book_unique_code']);
        }
        if (! empty($sort)) {
            $chapterModel = $chapterModel->orderBy($sort[0], $sort[1]);
        }

        if (intval($limit) > 0) {
            $chapterModel = $chapterModel->limit(intval($limit));
        }

        if (! empty($select) > 0) {
            $chapterModel = $chapterModel->select($select);
        }

        $chapter = $chapterModel->get();
        if (! empty($chapter)) {
            $chapter = $chapter->toArray();
        }
        $chapter = $this->formatter((array) $chapter);

        return (array) $chapter;
    }

    public function getOne($params)
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

        if (! empty($chapter)) {
            $chapterContent = $chapterContentModel->where('id', $chapter['id'])->first()->toArray();
            $chapter['content'] = $chapterContent['content'];
        }

        return (array) $chapter;
    }

    /**
     * @param $id
     * @param integer $category_id
     * @param integer $v
     * @return mixed
     */
    public function updateView($id,$category_id, $v = 1)
    {
        $chapterModel = new Chapter();
        $chapterModel = $chapterModel->setTable($category_id);

        return $chapterModel->where('id', $id)->increment('view', $v);
    }

    public function formatter($chapter)
    {
        return $chapter;
    }
}