@extends('mobile.common.base')

@section('content')
    @include('mobile.common.header')
    @include('mobile.common.search')

    @foreach($books as $k => $v)
        <div class="section-content">
            @include('mobile.common.section', ['books' => $v['list'], 'category_id' => $k, 'image_show' => $image_show])
        </div>
    @endforeach
    @include('mobile.common.footer')
@endsection
