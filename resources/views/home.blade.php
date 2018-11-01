@extends('layouts.app')

@section('meta_title', \App\Settings::get('site_name'))
@section('meta_description', \App\Settings::get('site_description'))
@section('meta_image', asset('images/site/web.jpg'))
@section('meta_url', route('home'))

@section('content')
    <div class="row">
        <div class="col-md-8 quizContainer">
            @include('quizzes.random-list')
        </div>
        <div class="col-md-4">
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
