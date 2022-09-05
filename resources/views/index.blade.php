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

            @if (Auth::check())
                @if (Auth::user()->role == 'user')
                    <div class="alert alert-warning mt-3 mb-3" role="alert">
                        This account can't add data, Please contact the admin to get a lecturer role
                    </div>
                @endif
            @endif
        </div>
    </body>
</html>