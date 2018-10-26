<?php

namespace App\Services;

use App\Models\Chapter;

class ChapterService extends Service
{
    public function get($params, $sort = [], $limit = 0, $select = [])
    {
        $chapterModel = new Chapter();
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
        if (isset($params['id']) && intval($params['id']) > 0) {
            $chapter = Chapter::where('id', intval($params['id']))->first()->toArray();
        }
        if (isset($params['unique_code'])) {
            $chapter = Chapter::where('unique_code', $params['unique_code'])->first()->toArray();
        }
        
        return (array) $chapter;
    }

    public function updateView($id, $v = 1)
    {
        return Chapter::where('id', $id)->increment('view', $v);
    }

    public function formatter($chapter)
    {
        if (! empty($chapter)) {
//            $prefixImg = '/author';
//            foreach ($chapter as $k => $v) {
//                if (! empty($v['image_local_url'])) {
//                    $v['image_local_url'] = $prefixImg . trim($v['image_local_url'], '.');
//                }
//                $v['description'] = strip_tags($v['description']);
//                $chapter[$k] = $v;
//            }
        }

        return $chapter;
    }
}