@extends('layouts.adminlte3.default')
@section('meta_title', $page->title)
@section('meta_description', $page->meta_description)
@section('page_title', $page->title)
@section('page_banner', imageUrl($page->image, 1200, 211))
@section('show_title', true)

@section('content')
    {!! $page->body !!}
@endsection
