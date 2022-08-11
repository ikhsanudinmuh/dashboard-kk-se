@include('layouts.header')
        <title>Home | Dashboard</title>    
    </head>
    <body>
        @include('layouts.navbar')
        <div class="container">
            @if (session('loginSuccess'))
                <div class="alert alert-success" role="alert">
                    {{ session('loginSuccess') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </body>
</html>