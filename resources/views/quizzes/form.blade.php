@extends('layouts.app')

@section('meta_title', \App\Settings::get('site_name'))
@section('meta_description', \App\Settings::get('site_description'))
@section('meta_image', asset('images/site/web.jpg'))
@section('meta_url', route('quizzes.index'))

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form">
                @include('layouts.messages')

                <form method="POST" enctype="multipart/form-data"
                      action="{{ $quiz->id ? route('quizzes.update', $quiz->id) : route('quizzes.store') }}">
                    @csrf
                    @if ($quiz->id)
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif
                    <div class="row">
                        <div class="col-md-8">
                            <h1>{{ __('Creación de Quizzes') }}</h1>
                        </div>
                        <div class="col-md-4">
                            {!! Form::select('enabled', '', [1 => __('Activado'), 0=> __('Desactivado')], 1) !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info">
                                {{ __('Puedes usar las variables: USERNAME, USERLASTNAME') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('title', __('Título'), $quiz->title)
                                ->attrs(['maxlength' => 150])
                                ->help(__('Título del Quiz, SEO y página')) !!}

                            {!! Form::text('slug', __('Slug'), $quiz->slug)
                                ->attrs(['maxlength' => 100])
                                ->help(__('URL de la página')) !!}

                            {!! Form::textarea('description', __('Descripción'), $quiz->description)
                                ->attrs(['maxlength' => 300])
                                ->help(__('Descripción del Quiz, SEO y página')) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::text('resultTitle', __('Título del resultado'), $quiz->resultTitle)
                                ->attrs(['maxlength' => 150])
                                ->help(__('Este título se mostrará en el resultado del Quiz')) !!}

                            {!! Form::textarea('resultDescription', __('Descripción del resultado'), $quiz->resultDescription)
                                ->attrs(['maxlength' => 300])
                                ->help(__('Esta descripción se mostrará en el resultado del Quiz')) !!}
                        </div>
                    </div>
                    <hr>
                    <h3>Imagen de portada</h3>
                    <br>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('Subir imagen') }}</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="coverImage" id="coverImage" accept="image/*">
                                        <label class="custom-file-label" for="coverImage">{{ __('Elegir imagen de portada') }}</label>
                                    </div>
                                </div>
                                <small class="form-text text-muted">{{ __('La imagen debe tener exactamente las medidas 1200x630px') }}</small>
                            </div>
                            <hr>
                            <a href="{{ $quiz->getCoverUrl() }}" target="_blank">
                                <img src="{{ $quiz->getCoverUrl() }}"
                                     alt="Cover image" id="coverImageContainer" class="img-fluid">
                            </a>
                        </div>
                        <div class="col-md-3">
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    {{ __('Coordenadas del avatar X/Y') }}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::text('avatarPositionX', '', $quiz->avatarPositionX)
                                        ->attrs(['min' => 0, 'max' => 1200])
                                        ->placeholder(__('Horizontal'))
                                        ->type('number') !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::text('avatarPositionY', '', $quiz->avatarPositionY)
                                        ->attrs(['min' => 0, 'max' => 1200])
                                        ->placeholder(__('Vertical'))
                                        ->type('number') !!}
                                </div>
                                <div class="col-lg-12">
                                    <small class="form-text text-muted">{{ __('Coordenadas de la foto de perfil del usuario (en px), en la imagen') }}</small>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-lg-12">
                                    {{ __('Tamaño del avatar') }}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::text('avatarWidth', '', $quiz->avatarWidth)
                                        ->attrs(['min' => 0, 'max' => 630])
                                        ->placeholder(__('Ancho'))
                                        ->type('number') !!}
                                </div>
                                <div class="col-sm-6">
                                    {!! Form::text('avatarHeight', '', $quiz->avatarHeight)
                                        ->attrs(['min' => 0, 'max' => 630])
                                        ->placeholder(__('Alto'))
                                        ->type('number') !!}
                                </div>
                                <div class="col-lg-12">
                                    <small class="form-text text-muted">{{ __('Tamaño de la foto de perfil en px') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="formActions text-right">
                        <input name="save" type="submit" class="btn btn-success" value="{{ __('Guardar') }}">
                        <input name="saveNClose" type="submit" class="btn btn-primary" value="{{ __('Guardar y cerrar') }}">
                        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                        @unless( empty($quiz->slug) )
                        <a href="{{ route('quiz.show', $quiz->slug) }}" class="btn btn-secondary" target="_blank">{{ __('Ver') }}</a>
                        @endunless
                    </div>
                </form>
                <hr>
                <div id="quizImageList">
                    <h3>Imágenes</h3>
                    <br>
                    @if ($quiz->id)
                        <form action="{{ route('quizzes.image.upload') }}" enctype="multipart/form-data"
                              class="dropzone m-2 p-2" id="my-awesome-dropzone">
                            @csrf
                            <input type="hidden" name="id" value="{{ $quiz->id }}">
                        </form>
                        <table class="table table-striped">
                            <tbody>
                            @foreach($quiz->images()->get() as $image)
                                <tr>
                                    <td>
                                        <a href="{{ $image->getImageUrl() }}" target="_blank">
                                            <img src="{{ $image->getImageUrl() }}" class="img-fluid" width="70">
                                        </a>
                                    </td>
                                    <td>
                                        Fecha: {{ $image->created_at->format('Y-m-d') }}
                                    </td>
                                    <td>{{ round($image->imageSize / 1024, 2) }} Kb</td>
                                    <td width="1%">
                                        {!! Form::open()->route('quizzes.image.destroy', ['id' => $image->id], false)->delete() !!}
                                        <button type="submit" class="btn btn-warning btn-sm removeImage">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <i>{{ __('Para subir las imágenes plantilla del quiz, primero guarda los cambios actuales.') }}</i>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
