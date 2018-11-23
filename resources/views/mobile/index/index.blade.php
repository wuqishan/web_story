@extends('mobile.common.base')

@section('content')
    @include('mobile.common.header')
    @include('mobile.common.search')
    @include('mobile.common.nav')

    <div>
        @include('mobile.common.section')
    </div>
    @include('mobile.common.footer')
@endsection
