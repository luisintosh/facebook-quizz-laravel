@extends('layouts.app')

@section('meta_title', $quiz->title)
@section('meta_description', $quiz->description)
@section('meta_image', $quiz->coverImage)
@section('meta_url', route('quiz.show', ['slug' => $quiz->slug]))

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm rounded mb-4">
                <div class="card-body">
                    @include('layouts.messages')
                    <h2 class="mb-4">{{ $quiz->title }}</h2>
                    <img src="{{ $quiz->coverImage }}" class="img-fluid mb-4" alt="{{ $quiz->title }}">
                    <div class="card-description text-secondary mb-4">
                        {{ $quiz->description }}
                    </div>
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-6">
                            {!! Form::open()->route('quiz.do-quiz', ['slug'=>$quiz->slug], false)->post() !!}
                            <button type="submit" class="btn btn-block btn-lg btn-primary animated pulse infinite slow">
                                <i class="fas fa-play"></i>
                                {{ __('Hacer Quiz') }}
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="ad text-center mb-4">
                        {{ \App\Settings::get('google_adsense') }}
                    </div>
                </div>
            </div>

            <div class="quizContainer">
                @include('quizzes.random-list')
            </div>
        </div>
        <div class="col-md-4">
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
