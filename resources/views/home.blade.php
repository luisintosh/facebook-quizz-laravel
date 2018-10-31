@extends('layouts.app')

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
