@extends('mobile.common.base')

@section('content')
    @include('mobile.common.header')
    @include('mobile.common.search')
    @include('mobile.common.nav')

    {{-- 首页展示2个分类的数据 --}}
    @include('mobile.common.section', ['category_id' => 1])
    @include('mobile.common.section', ['category_id' => 2])

    @include('mobile.common.footer')
@endsection
