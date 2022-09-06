{{-- halaman ketika user yang login tidak sesuai dengan role yang seharusnya --}}
{{-- mengambil header --}}
@include('layouts.header')
        <title>Unauthorized | {{ env('APP_NAME') }}</title>    
    </head>
    <body>
        {{-- mengambil navbar --}}
        @include('layouts.navbar')
        <div class="container">
            <div class="mt-3">
                <h4>You are not allowed to access that page!</h4>
                <a href="/">Back to home</a>                
            </div>
        </div>
    </body>
</html>