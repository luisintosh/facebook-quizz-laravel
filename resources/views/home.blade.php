@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach($quizzes as $quiz)
            <div class="col-sm-6 col-md-4 mb-3">
                <div class="card">
                    <img src="{{ $quiz->thumbImage }}" alt="{{ $quiz->title }}" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">{{ $quiz->title }}</h5>
                        <p class="card-text">
                            {{ $quiz->description }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
