@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body text-center">
                    <li class="nav-item"><a href="{{ route('social.auth', 'facebook') }}" class="navbar-btn btn btn-primary"><i class="fab fa-facebook-square"></i> Conectar</a></li>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
