@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm rounded mb-4">
                <div class="card-body">
                    <h2 class="mb-4">{{ $quiz->title }}</h2>
                    <img src="{{ $quiz->coverImage }}" class="img-fluid mb-4" alt="{{ $quiz->title }}">
                    <div class="card-description text-secondary mb-4">
                        {{ $quiz->description }}
                    </div>
                    <div class="row justify-content-center mb-4">
                        <div class="col-md-6">
                            <button class="btn btn-block btn-lg btn-primary">
                                <i class="fas fa-play"></i>
                                {{ __('Hacer Quiz') }}
                            </button>
                        </div>
                    </div>
                    <div class="ad text-center mb-4">
                        ## AD ##
                    </div>
                </div>
            </div>

            @foreach(\App\Quiz::random(15) as $quizRandom)
                <div class="card postItem mb-4 shadow-sm rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ route('quiz.show', $quizRandom->slug) }}">
                                    <img src="{{ $quizRandom->thumbImage }}" alt="{{ $quizRandom->title }}" class="card-img-top mb-3">
                                </a>
                                <a href="{{ route('quiz.show', $quizRandom->slug) }}" class="btn btn-block btn-outline-danger">
                                    <i class="fas fa-star"></i> {{ __('Tomar Quiz') }}
                                </a>
                            </div>
                            <div class="col-sm-8 card-info">
                                <a href="{{ route('quiz.show', $quizRandom->slug) }}">
                                    <h5 class="card-title">{{ $quizRandom->title }}</h5>
                                    <p class="card-text">
                                        {{ $quizRandom->description }}
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-4">
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
