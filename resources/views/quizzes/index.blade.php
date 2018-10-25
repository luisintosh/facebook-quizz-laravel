@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">{{ __('Creación de Quizzes') }}</div>
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
                        <th width="1%">{{ __('Acciones') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td><img src="{{ $quiz->coverImageUrl }}" alt="Quiz" width="70"></td>
                            <td>{{ $quiz->title }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('quizzes.destroy', $quiz->id) }}" data-method="DELETE" class="btn btn-outline-primary">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
