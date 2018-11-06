{{--SIDEBAR AD 1--}}
<div class="card sidebarAd mb-4 shadow-sm rounded">
    <div class="card-body">
        {{ \App\Settings::get('google_adsense') }}
    </div>
</div>

{{--SOCIAL NETWORKS--}}
<div class="socialNetworks mb-4">
    <div class="facebook">
        @if(\App\Settings::get('facebook_page', false))
            <div class="fb-page" data-href="{{ App\Settings::get('facebook_page') }}"
                 data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                <blockquote cite="{{ App\Settings::get('facebook_page') }}" class="fb-xfbml-parse-ignore">
                    <a href="{{ App\Settings::get('facebook_page') }}">{{ App\Settings::get('site_name') }}</a>
                </blockquote>
            </div>
        @endif
    </div>
</div>

{{--HOT QUIZZES--}}
<div class="card hotQuizzes mb-4 shadow-sm rounded">
    <div class="card-body">
        <h4 class="text-danger mb-4"><i class="fas fa-fire"></i> Top Quizzes</h4>
        @foreach(\App\Quiz::random(5) as $index => $hotQuizz)
            <a href="#">
                <figure class="hotQuiz">
                    <img src="{{ $hotQuizz->getThumbUrl() }}" alt="{{ $hotQuizz->title }}" class="img-fluid">
                    <span class="hotQuizNumber">{{ $index+1 }}</span>
                </figure>
                <span class="hotQuizTitle text-dark font-weight-bold text-justify">{{ $hotQuizz->title }}</span>
            </a>
            <hr>
        @endforeach
    </div>
</div>

{{--SIDEBAR AD 2--}}
<div class="card sidebarAd mb-4 shadow-sm rounded">
    <div class="card-body">
        {{ \App\Settings::get('google_adsense') }}
    </div>
</div>

{{--PRIVACY POLICY--}}
<div class="card mb-4 shadow-sm rounded">
    <div class="card-body">
        <small class="text-muted"><a href="{{ route('privacy') }}">{{ __('Políticas de privacidad') }}</a></small>
    </div>
</div>
