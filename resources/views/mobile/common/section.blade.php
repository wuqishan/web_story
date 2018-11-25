<div class="section">
    <h3 class="title">
        <span class="b_l">
            @if($category_id > 0 && $category_id <= 8)
                {{ \App\Models\Category::categoryMap($category_id) }}
            @else
                搜索结果
            @endif
        </span>
        <span class="b_r tab-nav">
            <a href="javascript:void(0);" onclick="$.getSectionInfo('{{ route('mobile-index', ['category_id' => $category_id, 'orderby' => 'view']) }}', $(this).parents('.section-content'), {});" class="cur">人气</a>
            <a href="#">热销</a>
        </span>
    </h3>
    <div class="box tab-pane clearfix">
        <div class="blist tab-content active">
            <ul>
                @foreach($books as $key => $book)
                <li>
                    <a href="">
                        @if($key < $image_show)
                            <div class="bcover fl">
                                <img src="{{ $book['image_local_url'] }}" alt="{{ $book['title'] }}" height="130" width="85"/>
                            </div>
                            <div class="bintro pl10">
                                <h4>{{ $book['title'] }}</h4>
                                <p>
                                    {{ \App\Models\Category::categoryMap($book['category_id']) }} . (@if($book['finished'] == 1){{ '已完本' }}@else{{ '连载中' }}@endif) . 501.2万字
                                    <br>
                                    {{ $book['description'] }}
                                </p>
                            </div>
                        @else
                            <div class="bintro">
                                <h4>
                                    {{ $book['title'] }}
                                </h4>
                                <p>
                                    {{ \App\Models\Category::categoryMap($book['category_id']) }} . (@if($book['finished'] == 1){{ '已完本' }}@else{{ '连载中' }}@endif) . 501.2万字
                                    <br>
                                </p>
                            </div>
                        @endif
                    </a>
                </li>
                @endforeach
                <li class="item_more">
                    <a href="" class="more">
                        更多作品&gt;
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @include('mobile.common.loading')
</div>