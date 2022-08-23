@include('layouts.header')
        <title>Home | {{ env('APP_NAME') }}</title>    
    </head>
    <body>
        @include('layouts.navbar')
        <div class="container">
            @if (session('loginSuccess'))
                <div class="alert alert-success mb-3" role="alert">
                    {{ session('loginSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </body>
</html>