
@if(isset($results['friend_link']['list']) && count($results['friend_link']['list']) > 0)
    <div class="widget widget_sentence">
        <h3>友情链接</h3>
        <div class="widget-sentence-link">
            @foreach($results['friend_link']['list'] as $v)
                <a href="{{ $v['link'] }}" title="{{ $v['title'] }}" target="_blank">{{ $v['title'] }}</a>&nbsp;&nbsp;&nbsp;
            @endforeach
        </div>
</div>
@endif