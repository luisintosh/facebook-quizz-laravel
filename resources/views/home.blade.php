@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            @foreach($quizzes as $quiz)
                <div class="card postItem mb-4 shadow-sm rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ route('quiz.show', $quiz->slug) }}">
                                    <img src="{{ $quiz->thumbImage }}" alt="{{ $quiz->title }}" class="card-img-top mb-3">
                                </a>
                                <a href="{{ route('quiz.show', $quiz->slug) }}" class="btn btn-block btn-outline-danger">
                                    <i class="fas fa-star"></i> {{ __('Tomar Quiz') }}
                                </a>
                            </div>
                            <div class="col-sm-8 card-info">
                                <a href="{{ route('quiz.show', $quiz->slug) }}">
                                    <h5 class="card-title">{{ $quiz->title }}</h5>
                                    <p class="card-text">
                                        {{ $quiz->description }}
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
