{{-- halaman untuk login --}}
{{-- mengambil header --}}
@include('layouts.header')
        <title>Login | {{ env('APP_NAME') }}</title>    
        <style>
            .box-form {
                border: 1px solid white; 
                background-color: white;
                padding: 25px;
                min-width: 25vh;
                max-width: 75vh;
                height: auto;
            }

            .logo-se {
                min-width: 25vh;
                max-width: 50vh;
                margin-bottom: 10px;
            }

            .layout {
                position: absolute;
                left: 50%;
                top: 50%;
                -webkit-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
            }

            .btn-google {
                background-color: #BF0000,
            }
        </style>
    </head>
    <body>
        <div class="container-fluid" style="background-color: #BF0000; height: 100vh;">
            <div class="layout">
                <img class="logo-se" src="/assets/logo kk se.png" alt="">
                <div class="box-form">
                    <div class="d-flex justify-content-center mb-3">
                        <h3>Login</h3>
                    </div>
                    {{-- menampilkan alert ketika user berhasil register --}}
                    @if (session('registerSuccess'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('registerSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- menampilkan alert ketika login gagal --}}
                    @if (session('loginFailed'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('loginFailed') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- <form action="{{ route('auth.login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Email Address :</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="" name="email">
                            <div class="invalid-feedback">@error('email') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Password :</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="" name="password">
                            <div class="invalid-feedback">@error('email') {{ $message }} @enderror</div>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn text-white" style="background-color: #BF0000">Login</button>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="/">Back to home</a>                            
                        </div>
                    </form> --}}
                    {{-- memindahkan user ke halaman login google --}}
                    <div class="d-flex justify-content-center mb-3">
                        <a href="{{ route('redirect') }}" class="btn text-white" style="background-color: #BF0000"><img src="/assets/google.png" alt="" srcset="" style="height: 25px;"> Login with Google</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="/">Back to home</a>                            
                    </div>
                </div>
            </div>
        </div>        
    </body>
</html>