@if (session('success'))
    <div class="alert alert-success mb-4">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            {{ session('success') }}
        </ul>
    </div>
@endif


@if (isset($errors) && $errors->any())
    <div class="alert alert-danger mb-4">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
