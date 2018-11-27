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
@if($length * $page < $total)
    <li class="item_more">
        <a href="javascript:void(0);" onclick="$.getBookMore('{!! route('mobile-book-more') !!}');" class="more">
            更多作品&gt;
        </a>
    </li>
@endif