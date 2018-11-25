<div class="search">
    <div class="searchbox mt10 clearfix">
        <form action="{{ route('mobile-article-index') }}" method="get">
            <input type="hidden" name="category_id" value="{{ request()->get('category_id', 0) }}"/>
            <input name="keyword" type="text" class="t_i" placeholder="书本搜索" autocomplete="off" value="{{ request()->get('keyword') }}" />
            <div class="searchbtn">
                <span class="t_b"></span>
                <span class="t_t">搜索</span>
                <input type="submit" value=""/>
            </div>
        </form>
    </div>
</div>