<?php $pagingHelper = \App\Helper\PagingHelper::pageInit($data['total'], $data['length']); ?>

<nav id="paging-nav">
    <ul class="pagination">
        {{-- 如果是章节的list，则显示翻页样式不同 --}}
        @if(isset($chapter_list) && $chapter_list && \App\Helper\ToolsHelper::isMobile())

            @if($pagingHelper->getPrevUrl())
                <li><a href="{{ $pagingHelper->getPrevUrl() }}" aria-label="Previous"><span aria-hidden="true">上一页</span></a></li>
            @endif
                <li class="page-go-to-val">
                    <a href="javascript:void(0);" aria-label="Go to">
                        {!! \App\Helper\PagingHelper::chapterListPage($pagingHelper->getNumPages(), $data['length'], $pagingHelper->getCurrentPage()) !!}
                    </a>
                </li>
            @if($pagingHelper->getNextUrl())
                <li><a href="{{ $pagingHelper->getNextUrl() }}" aria-label="Next"><span aria-hidden="true">下一页</span></a></li>
            @endif

        @else
            @if($pagingHelper->getPrevUrl())
                <li><a href="{{ $pagingHelper->getPrevUrl() }}" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
            @endif
            @foreach($pagingHelper->getPages() as $page)
                @if($page['url'])
                    <li @if($page['isCurrent']) class="active" @endif><a href="{{ $page['url'] }}">{{ $page['num'] }} <span class="sr-only">(current)</span></a></li>
                @else
                    <li><a href="javascript:void(0)">{{ $page['num'] }} <span class="sr-only"> </span></a></li>
                @endif
            @endforeach
            @if($pagingHelper->getNextUrl())
                <li><a href="{{ $pagingHelper->getNextUrl() }}" aria-label="Next"><span aria-hidden="true">»</span></a></li>
            @endif


            @if(\App\Helper\ToolsHelper::isMobile())
                <li><a href="javascript:void(0)">跳转 <span class="sr-only"> </span></a></li>
                <li class="page-go-to-val">
                    <a href="javascript:void(0);" aria-label="Go to">
                        <input type="text" placeholder="{{ $pagingHelper->getCurrentPage() }}">
                    </a>
                </li>
                <li class="page-go-to-btn"><a href="javascript:goToPage('{{ request()->url() }}');">Go<span class="sr-only"> </span></a></li>
            @else
                <li><a href="javascript:void(0)">跳转至 <span class="sr-only"> </span></a></li>
                <li class="page-go-to-val">
                    <a href="javascript:void(0);" aria-label="Go to">
                        <input type="text" placeholder="{{ $pagingHelper->getCurrentPage() }}">
                    </a>
                </li>
                <li><a href="javascript:void(0)">页<span class="sr-only"> </span></a></li>
                <li class="page-go-to-btn"><a href="javascript:goToPage('{{ request()->url() }}', parseInt($('.page-go-to-val a input').val()));">Go<span class="sr-only"> </span></a></li>
            @endif
        @endif
    </ul>
</nav>

<script>
    /**
     * 跳转到指定页
     *
     * @param url
     * @param goToPage
     */
    function goToPage(url, goToPage) {
        var totalPages = parseInt('{{ $pagingHelper->getNumPages() }}');
        if (goToPage < 1 || goToPage > totalPages) {
            alert('请输入正确格式的页码');
        } else {
            location.href=url + '?page=' + goToPage;
        }
    }
</script>