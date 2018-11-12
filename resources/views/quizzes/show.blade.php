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
                    <div class="ad text-center">
                        @include('layouts.ad-rectangle')
                    </div>

                    <img src="{{ $quiz->getCoverUrl() }}" class="img-fluid mb-4"
                         alt="{{ $quiz->title }}">

                    <h2 class="mb-4">{{ $quiz->title }}</h2>

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

                    <div class="mt-3 mb-4 text-muted">
                        <h4><small>¿Cómo puedo compartir el resultado de mi Quiz en mis redes sociales?</small></h4>
                        <p><small>Es muy sencillo publicar el resultado de este quiz con tus amigos, lo único que debes hacer
                                es oprimir el botón de la red social que quieres usar y al instante se abrirá una ventana
                                que, dependiendo de la red social, te pedirá que ingreses un comentario o texto sobre tu
                                publicación y listo a publicarla. Ahora ya sabes como compartir tus resultados con amigos
                                y familiares, aprovecha e invítalos a usar esta App para que juntos se diviertan jugando
                                estos quizzes.</small></p>
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
