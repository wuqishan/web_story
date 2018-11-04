<?php

namespace App\Helper;


use JasonGrimes\Paginator;

class PagingHelper
{
    /**
     * @param integer       $total              总数
     * @param integer       $pageNumber         每页显示的条数
     * @param integer       $maxPageShow        最大显示页数
     * @return Paginator    $paginator
     */
    public static function pageInit($total, $pageNumber, $maxPageShow = 7)
    {
        $currentPage = request()->get('page', 1);
        $requestUri = request()->getRequestUri();
        $urlPattern = preg_replace("/(\?|&)page=\d*/", '\1page=(:num)', $requestUri);

        $paginator = new Paginator($total, $pageNumber, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow($maxPageShow);

        return $paginator;
    }

    /**
     * 初始化显示每页显示多少条数据
     *
     * @return string
     */
    public static function pageNumber()
    {
        $pageNumber = [6, 10, 20, 30, 50, 100, 300, 500, 1000, 2000, 3000, 5000];

        $options = [];
        foreach ($pageNumber as $v) {
            $selected = '';
            if (request()->get('length') == $v) {
                $selected = 'selected';
            }
            $options[] = "<option value='{$v}' {$selected}>{$v}</option>";
        }

        return '<select class="page_number">' . implode('', $options) . '</select>';
    }
}

