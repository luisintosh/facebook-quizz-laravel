@extends('layouts.app')

@section('meta_title', \App\Settings::get('site_name'))
@section('meta_description', \App\Settings::get('site_description'))
@section('meta_image', asset('images/site/web.jpg'))
@section('meta_url', route('home'))

@section('content')
    <div class="row">
        <div class="col-md-8 quizContainer">
            <div class="card mb-4 shadow-sm rounded">
                <div class="card-body">
                    <h3>Bienvenido a nuestra colecci&oacute;n de Quizzes</h3>
                    <p>Diviertete con nuestros quizzes sobre cultura, salud, deportes, pol&iacute;tica, finanzas,
                        historia, religi&oacute;n, b&uacute;squeda de empleo y mucho m&aacute;s. Chequea de vez en
                        cuando para que descubras los nuevos quizzes y sigas divirtiendote a la vez que compartes
                        tus resultados con tus amigos y familiares para que ellos tambien se sumen a esta divertida
                        p&aacute;gina.</p>
                </div>
            </div>

            @include('quizzes.random-list')
        </div>
        <div class="col-md-4">
            @include('layouts.sidebar')
        </div>
    </div>
@endsection
