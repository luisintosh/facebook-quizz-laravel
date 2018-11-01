@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm rounded mb-4">
                <div class="card-body">
                    @include('layouts.messages')

                    <h1>{{ __('Configuraciones') }}</h1>
                    <hr>

                    {!! Form::open()->route('settings.store')->post() !!}

                    @foreach(\App\Settings::$settings as $setting)
                        @if($setting[0] == '---')
                            <hr>
                        @elseif($setting[0] == 'text')
                            {!! Form::text($setting[1], __($setting[2]), \App\Settings::get($setting[1])) !!}
                        @elseif($setting[0] == 'boolean')
                            {!! Form::select($setting[1], __($setting[2]), [__('SI'), __('NO')], \App\Settings::get($setting[1])) !!}
                        @endif
                    @endforeach

                    <button class="btn btn-block btn-success">
                        {{ __('Guardar') }}
                    </button>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
