@extends('layouts.app')

@section('meta_title', $quiz->resultTitle)
@section('meta_description', $quiz->resultDescription)
@section('meta_image', $userQuiz->getImageUrl())
@section('meta_url', route('quiz.result', ['slug' => $quiz->slug, 'id' => $userQuiz->id]))

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm rounded mb-4 animated tada">
                <div class="card-body">
                    <h2 class="mb-4">{{ $quiz->resultTitle }}</h2>
                    <img src="{{ $userQuiz->getImageUrl() }}" class="img-fluid mb-4" alt="{{ $quiz->resultTitle }}">
                    <div class="ad text-center mb-4">
                        {{ \App\Settings::get('google_adsense') }}
                    </div>
                    <div class="card-description text-secondary mb-4">
                        {{ $quiz->resultDescription }}
                    </div>
                    <div class="bg-light text-center mb-3 p-3">
                        <p>{{ __('¡Comparte este resultado con tus amigos!') }}</p>
                        <br>
                        <div class="addthis_inline_share_toolbox"></div>
                        <br>
                        {!! Form::open()->route('quiz.do-quiz', ['slug'=>$quiz->slug], false)->post()->id('doQuiz') !!}
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-gamepad"></i>
                            {{ __('Volver a jugar') }}
                        </button>
                        {!! Form::close() !!}
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

@if($redirectToOriginal)
    <script>
      window.location.href = "{{ route('quiz.show', ['slug' => $quiz->slug]) }}";
    </script>
@endif
