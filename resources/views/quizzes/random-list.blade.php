@foreach(\App\Quiz::random(5) as $randomQuiz)
    <div class="card postItem mb-4 shadow-sm rounded">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <a href="{{ route('quiz.show', $randomQuiz->slug) }}">
                        <img src="{{ $randomQuiz->thumbImage }}" alt="{{ $randomQuiz->title }}" class="card-img-top mb-2">
                    </a>
                </div>
                <div class="col-sm-7 card-info text-justify">
                    <a href="{{ route('quiz.show', $randomQuiz->slug) }}">
                        <h5 class="card-title">{{ $randomQuiz->title }}</h5>
                        <p class="card-text">
                            {{ $randomQuiz->description }}
                        </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
