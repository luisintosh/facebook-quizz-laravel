@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm rounded mb-4 animated tada">
                <div class="card-body">
                    <h2 class="mb-4">{{ $quiz->resultTitle }}</h2>
                    <img src="{{ $userQuiz->imageUrl }}" class="img-fluid mb-4" alt="{{ $quiz->resultTitle }}">
                    <div class="card-description text-secondary mb-4">
                        {{ $quiz->resultDescription }}
                    </div>
                    <div class="shareButtonsBlock text-center mb-3 p-3">
                        <div class="addthis_inline_share_toolbox"></div>
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