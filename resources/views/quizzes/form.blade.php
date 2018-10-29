@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form">
                @include('layouts.messages')

                <form method="{{ $quiz->id ? 'PUT' : 'POST' }}" enctype="multipart/form-data"
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
                            <div class="form-group">
                                <select name="enabled" id="enabled" class="form-control  form-control-sm">
                                    <option value="1">{{ __('Activado') }}</option>
                                    <option value="0">{{ __('Desactivado') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">{{ __('Título') }}</label>
                                <input name="title" id="title" type="text" class="form-control"
                                       value="{{ $quiz->title }}" maxlength="150">
                                <small class="form-text text-muted">{{ __('Título del Quiz, SEO y página') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="slug">{{ __('Slug') }}</label>
                                <input name="slug" id="slug" type="text"
                                       class="form-control" value="{{ $quiz->slug }}" maxlength="100">
                                <small class="form-text text-muted">{{ __('URL de la página') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Descripción') }}</label>
                                <textarea name="description" id="description" class="form-control htmlEditor"
                                          rows="5" maxlength="150">{{ $quiz->description }}</textarea>
                                <small class="form-text text-muted">{{ __('Descripción del Quiz, SEO y página') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="resultTitle">{{ __('Título del resultado') }}</label>
                                <input name="resultTitle" id="resultTitle" type="text"
                                       class="form-control" value="{{ $quiz->resultTitle }}" maxlength="150">
                                <small class="form-text text-muted">{{ __('Este título se mostrará en el resultado del Quiz') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="resultDescription">{{ __('Descripción del resultado') }}</label>
                                <textarea name="resultDescription" id="resultDescription" class="form-control htmlEditor"
                                          rows="5" maxlength="150">{{ $quiz->description }}</textarea>
                                <small class="form-text text-muted">{{ __('Esta descripción se mostrará en el resultado del Quiz') }}</small>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h3>Imagen de portada</h3>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <ul class="list-group">
                                <li class="list-group-item">{{ __('Tamaño de la imágen: ') }} 1200x630 px</li>
                                <li class="list-group-item">{{ __('Tamaño de la foto de perfil: ') }} 300x300 px</li>
                            </ul>
                            <br>
                            <label for="avatarPositionX">{{ __('Coordenadas del avatar X/Y') }}</label>
                            <div class="row">
                                <div class="col">
                                    <input name="avatarPositionX" id="avatarPositionX" type="number" placeholder="X"
                                           class="form-control" value="{{ $quiz->avatarPositionX }}">
                                </div>
                                <div class="col">
                                    <input name="avatarPositionY" id="avatarPositionY" type="number" placeholder="Y"
                                           class="form-control" value="{{ $quiz->avatarPositionY }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ __('Subir cover') }}</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="coverImage" id="coverImage" accept="image/*">
                                        <label class="custom-file-label" for="coverImage">{{ __('Elegir imagen de portada') }}</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback">
                                    {{ __('La imagen debe tener exactamente las medidas 1200x630px') }}
                                </div>
                            </div>
                            <hr>
                            <a href="{{ $quiz->coverImage ? $quiz->coverImage : asset('images/quizzes/quizCoverImagePlaceholder.png') }}" target="_blank">
                                <img src="{{ $quiz->coverImage ? $quiz->coverImage : asset('images/quizzes/quizCoverImagePlaceholder.png') }}"
                                     alt="Cover image" id="coverImageContainer" class="img-fluid">
                            </a>
                        </div>
                    </div>
                    <hr>
                    <div class="formActions text-right">
                        <input name="save" type="submit" class="btn btn-success" value="{{ __('Guardar') }}">
                        <input name="saveNClose" type="submit" class="btn btn-primary" value="{{ __('Guardar y cerrar') }}">
                        <a href="{{ route('quizzes.index') }}" class="btn btn-secondary">{{ __('Cancelar') }}</a>
                    </div>
                </form>
                <hr>
                <div id="quizImageList">
                    <h3>Imágenes</h3>
                    <br>
                    @if ($quiz->id)
                        <form action="{{ route('quizzes.image.upload') }}"
                              class="dropzone m-2 p-2"
                              id="my-awesome-dropzone">
                            @csrf
                            <input type="hidden" name="id" value="{{ $quiz->id }}">
                        </form>
                        <table class="table table-striped">
                            <tbody>
                            @foreach($quiz->images() as $image)
                                <tr>
                                    <td class="imageTag"><img src="#" class="img-fluid" height="50"></td>
                                    <td class="imageInput">
                                        <input type="file" name="imageList[]" accept="image/*"
                                               class="form-control-file imageListInput" value="{{ $image->imageUrl }}">
                                    </td>
                                    <td class="imageSize">{{ $image->imageSize }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm removeImage">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
