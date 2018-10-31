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

            <div class="quizContainer">
                @include('quizzes.random-list')
            </div>
        </div>
        <div class="col-md-4">
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
