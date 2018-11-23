<div class="nav">
    <div class="mt10 clearfix index-nav">
        <ul>
            @foreach(\App\Models\Category::getAll() as $v)
            <li>
                <a href=""><img src="{{ asset('/mobile/static/images/fenlei.png') }}"><span>{{ $v['name'] }}</span></a>
            </li>
            @endforeach
            <li>
                <a href=""><img src="{{ asset('/mobile/static/images/fenlei.png') }}"><span>更多</span></a>
            </li>
        </ul>
    </div>
</div>