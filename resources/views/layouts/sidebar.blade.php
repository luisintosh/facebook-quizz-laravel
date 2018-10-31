{{--SIDEBAR AD 1--}}
<div class="card sidebarAd mb-4 shadow-sm rounded">
    <div class="card-body">
        ## AD ##
    </div>
</div>

{{--SOCIAL NETWORKS--}}
<div class="socialNetworks mb-4">
    <div class="facebook">
        ## FACEBOOK LIKE BOX ##
    </div>
</div>

{{--HOT QUIZZES--}}
<div class="card hotQuizzes mb-4 shadow-sm rounded">
    <div class="card-body">
        <h4 class="text-danger mb-4"><i class="fas fa-fire"></i> Top Quizzes</h4>
        @foreach(\App\Quiz::random(5) as $index => $hotQuizz)
            <a href="#">
                <figure class="hotQuiz">
                    <img src="{{ $hotQuizz->thumbImage }}" alt="{{ $hotQuizz->title }}" class="img-fluid">
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
        ## AD ##
    </div>
</div>
