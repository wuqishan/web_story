<?php

namespace App\Helper;


use JasonGrimes\Paginator;

class PagingHelper
{
    /**
     * @param integer       $total              总数
     * @param integer       $pageNumber         每页显示的条数
     * @param string        $currentPageField   获取当前页数的键，默认为:page
     * @param integer       $maxPageShow        最大显示页数
     * @return Paginator    $paginator
     */
    public static function pageInit($total, $pageNumber, $currentPageField = 'page', $maxPageShow = 7)
    {
        $currentPage = request()->get($currentPageField, 1);
        $requestUri = request()->getRequestUri();
        $urlPattern = preg_replace("/&{$currentPageField}=\d*/", '', $requestUri);
        $urlPattern = preg_replace("/\?{$currentPageField}=\d*/", '', $urlPattern);
        if (strpos($urlPattern, '?') === false) {
            $urlPattern .= '?page=(:num)';
        } else {
            $urlPattern .= '&page=(:num)';
        }
        $paginator = new Paginator($total, $pageNumber, $currentPage, $urlPattern);
        $paginator->setMaxPagesToShow($maxPageShow);

        return $paginator;
    }


}

