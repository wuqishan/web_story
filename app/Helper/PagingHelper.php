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
        if (preg_match("/(\?|&)page=\d*/", $requestUri)) {
            $urlPattern = preg_replace("/(\?|&)page=\d*/", '\1page=(:num)', $requestUri);
        } else {
            if (strpos($requestUri, '?') === false) {
                $urlPattern = $requestUri . '?page=(:num)';
            } else {
                $urlPattern = $requestUri . '&page=(:num)';
            }
        }
        $paginator = new Paginator($total, $pageNumber, $currentPage, $urlPattern);

        // 如果是手机则不显示过多的分页样式
        if (ToolsHelper::isMobile()) {
            $maxPageShow = 4;
        }
        $paginator->setMaxPagesToShow($maxPageShow);

        return $paginator;
    }

    /**
     * 初始化显示每页显示多少条数据
     *
     * @param int $length
     * @return string
     */
    public static function pageNumber($length = 0)
    {
        $pageNumber = [6, 10, 20, 30, 50, 100, 300, 500, 1000, 2000, 3000, 5000];

        $options = [];
        foreach ($pageNumber as $v) {
            $selected = '';
            if (request()->get('length') == $v) {
                $selected = 'selected';
            } else if ($length == $v) {
                $selected = 'selected';
            }
            $options[] = "<option value='{$v}' {$selected}>{$v}</option>";
        }

        return '<select class="page_number">' . implode('', $options) . '</select>';
    }

    /**
     * 章节分页
     *
     * @param $pages
     * @param $offset
     * @param int $current_page
     * @return string
     */
    public static function chapterListPage($pages, $offset, $current_page = 1)
    {
        $page_template = [];
        if ($pages > 0) {
            for ($i = 0; $i < $pages; $i++) {
                $selected = $current_page == ($i + 1) ? 'selected' : '';
                $start = $i * $offset + 1;
                $end = ($i + 1) * $offset;
                $page_template[] = sprintf('<option %s value="%d">第 %d - %d 章</option>', $selected, $i + 1, $start, $end);
            }
        }

        return '<select onchange="goToPage(\'' . request()->url() . '\' ,$(this).val())">' . implode('', $page_template) . '</select>';
    }
}

