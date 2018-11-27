<div class="section section_{{ $category_id }}">
    <h3 class="title">
        <span class="b_l">
            @if($category_id > 0 && $category_id <= 8)
                {{ \App\Models\Category::categoryMap($category_id) }}
            @else
                搜索结果
            @endif
        </span>
        <span class="b_r tab-nav">
            <a href="javascript:void(0);" onclick="$.getSectionInfo('{{ route('mobile-book-list', ['category_id' => $category_id, 'orderby' => 'view']) }}', $('.section_{{ $category_id }}'), {});" class="cur">人气</a>
            <a href="#">热销</a>
        </span>
    </h3>
    <div class="box tab-pane clearfix">
        <div class="blist tab-content active">
            <ul class="book_list">

                {{-- 此处放book list --}}

            </ul>
        </div>
    </div>
    @include('mobile.common.loading')
</div>
<script>
$(function () {
    $.getSectionInfo('{!!  route('mobile-book-list', ['category_id' => $category_id, 'orderby' => 'view']) !!}', $('.section_{{ $category_id }}'), {});
});
</script>