@extends('layouts.app')

@section('meta_title', $quiz->title)
@section('meta_description', $quiz->description)
@section('meta_image', $quiz->getCoverUrl())
@section('meta_url', route('quiz.show', ['slug' => $quiz->slug]))

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm rounded mb-4">
                <div class="card-body">
                    @include('layouts.messages')
                    <h2 class="mb-4">{{ $quiz->title }}</h2>
                    <img src="{{ $quiz->getCoverUrl() }}" class="img-fluid mb-4" alt="{{ $quiz->title }}">
                    <div class="ad text-center mb-4">
                        {{ \App\Settings::get('google_adsense') }}
                    </div>
                    <div class="card-description text-secondary mb-4">
                        {{ $quiz->description }}
                    </div>
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-6">
                            {!! Form::open()->route('quiz.do-quiz', ['slug'=>$quiz->slug], false)->post()->id('doQuiz') !!}
                            <button type="submit" class="btn btn-block btn-lg btn-primary">
                                <i class="fas fa-gamepad"></i>
                                {{ __('Jugar usando Facebook') }}
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @include('layouts.loading')
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
