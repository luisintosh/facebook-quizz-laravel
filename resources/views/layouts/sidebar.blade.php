{{--SIDEBAR AD 1--}}
<div class="card sidebarAd mb-4">
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
<div class="card hotQuizzes mb-4">
    <h4><i class="fas fa-fire"></i> Top Quizzes</h4>
    <div class="card-body">
        @foreach($hotQuizzes as $index => $hotQuizz)
            <figure class="hotQuiz">
                <img src="{{ $hotQuizz->thumbPath }}" alt="{{ $hotQuizz->title }}" class="img-fluid">
                <span class="hotQuizNumber">{{ $index+1 }}</span>
            </figure>
            <span class="hotQuizTitle font-weight-bold">{{ $quiz->title }}</span>
        @endforeach
    </div>
</div>
{{--SIDEBAR AD 2--}}
<div class="card sidebarAd mb-4">
    <div class="card-body">
        ## AD ##
    </div>
</div>
