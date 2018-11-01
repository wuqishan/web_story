<?php

namespace App\Services;

use App\Models\ChapterContent;
use App\Services\Spider\SubSpiderService;

class ChapterContentService extends Service
{
    public function getContentFromUrl($url)
    {
        $subSpider = new SubSpiderService();

        return $subSpider->getContent($url);
    }

    public function updateContent($id, $category_id, $content)
    {
        $model = new ChapterContent();
        $model = $model->setTable($category_id);

        return $model->where('id', $id)->update(['content' => $content]);
    }
}