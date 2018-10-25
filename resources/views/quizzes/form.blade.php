@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>{{ __('Creación de Quizzes') }}</h1>
            <hr>
            <div class="form">
                <form method="{{ $quiz->id ? 'PUT' : 'POST' }}"
                      action="{{ $quiz->id ? route('quizzes.update', $quiz->id) : route('quizzes.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">{{ __('Título') }}</label>
                                <input name="title" id="title" type="text" class="form-control" value="{{ $quiz->title }}">
                                <small class="form-text text-muted">{{ __('Título del Quiz, SEO y página') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="slug">{{ __('Slug') }}</label>
                                <input name="slug" id="slug" type="text"
                                       class="form-control" value="{{ $quiz->slug }}">
                                <small class="form-text text-muted">{{ __('URL de la página') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ __('Descripción') }}</label>
                                <textarea name="description" id="description" class="form-control"
                                          rows="5">{{ $quiz->description }}</textarea>
                                <small class="form-text text-muted">{{ __('Descripción del Quiz, SEO y página') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="resultTitle">{{ __('Título del resultado') }}</label>
                                <input name="resultTitle" id="resultTitle" type="text"
                                       class="form-control" value="{{ $quiz->resultTitle }}">
                                <small class="form-text text-muted">{{ __('Este título se mostrará en el resultado del Quiz') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="resultDescription">{{ __('Descripción del resultado') }}</label>
                                <textarea name="resultDescription" id="resultDescription" class="form-control"
                                          rows="5">{{ $quiz->description }}</textarea>
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
                            <div class="form-group">
                                <label for="avatarPositionX">{{ __('Coordenada X') }}</label>
                                <input name="avatarPositionX" id="avatarPositionX" type="number"
                                       class="form-control" value="{{ $quiz->avatarPositionX }}">
                                <small class="form-text text-muted">{{ __('Coordenada horizontal de la foto de perfil') }}</small>
                            </div>
                            <div class="form-group">
                                <label for="avatarPositionY">{{ __('Coordenada Y') }}</label>
                                <input name="avatarPositionY" id="avatarPositionY" type="number"
                                       class="form-control" value="{{ $quiz->avatarPositionY }}">
                                <small class="form-text text-muted">{{ __('Coordenada vertical de la foto de perfil') }}</small>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="uploader text-center">
                                <input name="coverImageUrl" type="file" class="form-control-file" value="{{ $quiz->coverImageUrl }}">
                            </div>
                            <hr>
                            <img src="{{ $quiz->coverImageUrl ? $quiz->coverImageUrl : 'https://via.placeholder.com/1200x630' }}"
                                 alt="Cover image" id="imageContainer" class="img-fluid">
                        </div>
                    </div>
                    <hr>
                    <h3>Imágenes</h3>
                    <br>
                    <div class="text-right mb-3">
                        <button type="button" id="addFileInput" class="btn btn-primary">
                            <i class="fas fa-plus"></i>
                            {{ __('Agregar imagen') }}
                        </button>
                    </div>
                    <div id="quizImageList">
                        <table class="table table-striped">
                            <tbody>
                            @if($quiz->images()->count() == 0)
                                <tr>
                                    <td class="imageTag"><img src="" class="img-fluid" height="50"></td>
                                    <td class="imageInput">
                                        <input type="file" name="imageList[]" accept="image/*"
                                               class="form-control-file imageListInput" value="">
                                    </td>
                                    <td class="imageSize"></td>
                                    <td>
                                        <button type="button" class="btn btn-light btn-sm removeImage">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endif
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


                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Image elements
        var imageList = $('#quizImageList table tbody');
        var imageRow = $('#imageRowTemplate').parent().html();

        // If the list doesn't have at least a row
        if ( imageList.find('tr').length === 1 ) {
          imageList.append(imageRow);
        }

        // Add a file input
        $('#addFileInput').click(function () {
          imageList.append(imageRow);
        });

        // Check image width and height
        $('.imageListInput').change(function () {
          var self = this;
          var fr = new FileReader;

          fr.onload = function() {
            var img = new Image;

            img.onload = function() {
              if (! (img.width === 1200 && img.height === 630) ) {
                self.value = '';
                alert('The image must have a size of 1200x630px');
              }
            };

            img.src = fr.result;
          };

          fr.readAsDataURL(this.files[0]);

        });
    </script>
@endpush
