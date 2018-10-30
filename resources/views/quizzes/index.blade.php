@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>{{ __('Lista de Quizzes') }}</h1>
            <hr>
            <div class="controls text-right mb-3">
                <a href="{{ route('quizzes.create') }}" class="btn btn-primary">{{ __('Nuevo Quiz') }}</a>
            </div>
            <div class="table">
                <table class="table table-striped dt">
                    <thead>
                    <tr>
                        <th width="1%">{{ __('Imágen') }}</th>
                        <th>{{ __('Título') }}</th>
                        <th width="1%">{{ __('Activo') }}</th>
                        <th width="1%">{{ __('Acciones') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td>
                                <a href="{{ $quiz->coverImage }}" target="_blank">
                                    <img src="{{ $quiz->thumbImage }}" alt="Quiz" width="70">
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('quizzes.edit', $quiz->id) }}">
                                    {{ $quiz->title }}
                                </a>
                            </td>
                            <td>
                                @if($quiz->enabled)
                                    <i class="fas fa-check text-success"></i>
                                @else
                                    <i class="fas fa-times text-muted"></i>
                                @endif
                            </td>
                            <td>
                                {!! Form::open()->route('quizzes.destroy', ['id'=>$quiz->id], false)->delete() !!}
                                <div class="btn-group">
                                    <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="submit" class="btn btn-outline-primary">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
