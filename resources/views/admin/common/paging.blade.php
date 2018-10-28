<?php $pagingHelper = \App\Helper\PagingHelper::pageInit($results['data']['total'], $results['data']['length']); ?>

<div class="bs-component" style="margin-bottom: 15px;">
    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group mr-2" role="group" aria-label="First group">

            @if($pagingHelper->getPrevUrl())
                <a href="{{ $pagingHelper->getPrevUrl() }}" class="btn btn-secondary weight-normal">上一页</a>
            @endif

            @foreach($pagingHelper->getPages() as $page)
                @if($page['url'])
                    <a href="{{ $page['url'] }}" class="btn btn-secondary weight-normal @if($page['isCurrent']){{ 'active' }}@endif">{{ $page['num'] }}</a>
                @else
                    <a href="javascript:void(0)" class="btn btn-secondary weight-normal">{{ $page['num'] }}</a>
                @endif
            @endforeach

            @if($pagingHelper->getNextUrl())
                <a href="{{ $pagingHelper->getNextUrl() }}" class="btn btn-secondary weight-normal">下一页</a>
            @endif

            <a href="#" class="btn btn-secondary weight-normal">共 {{ $pagingHelper->getTotalItems() }} 条数据</a>
        </div>
    </div>
</div>