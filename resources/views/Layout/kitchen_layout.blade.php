<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        <!-- Styles -->
        <link rel="stylesheet" href="{{asset('/css/style.css')}}">
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
        <style>
            td{
                vertical-align: middle;
            }
        </style>
                <link rel="stylesheet" href="{{ asset('/bootstrap/css/bootstrap.min.css') }}">
                <script src="{{ asset('/jquery/jquery.js')}}"></script>

    </head>
    <body class="antialiased">
          <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="#"><img src="{{asset('storage/logo/logo-34.png')}}" class="mr-2" width="150px" height="50px" alt="logo"/></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                      <a class="nav-link active" aria-current="page" id="home" href="/kitchen/order">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="cookedorders" href="/kitchen/cooked-order">Cooked Orders</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="menus" href="/kitchen/menus">Menus</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="purchase" href="/kitchen/purchase">Purchase</a>
                  </li>
                </ul>
    
                <div class="me-5">
                  <div class="dropdown me-5">
                    <div class="dropdown-toggle d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <img src="{{asset('storage/user_images/user-logo.png')}}" width="auto" height="30px" alt="">
                      <div class="username ms-2">@if($user){{$user->name}}@endif</div>
                    </div>
                    <ul class="dropdown-menu mt-4">
                      <li><a class="dropdown-item" href="/kitchen/profile">Profile</a></li>
                        <li>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <a href="#" class="dropdown-item" id="logout">
                            <input type="submit" class="border-0 bg-transparent p-0" value="Logout">
                            </a>
                          </form>
                        </li>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>   
          </nav>
        @yield('content')

        <script src="{{ asset('/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

        <script src="{{asset('/js/menu-filter.js')}}" type="text/javascript"></script>
        
        <script>
          $('#logout').click(function() {
            console.log('logout')
            $('#logout-form').submit();
          })
        $('#profile').addClass('d-none');

            function openimage(){
                let uploadimage = document.getElementById('uploadimage');
                let menuimage = document.getElementById('menuimage');

                menuimage.click();
            }

        const input = document.getElementById('menuimage');
        const previewPhoto = (path) => {
        const file = input.files;
        if (file) {
            const fileReader = new FileReader();
            const preview = document.getElementById('uploadimage');
            fileReader.onload = function (event) {
                preview.setAttribute('src', event.target.result);
            }
            if(file[0]){

                fileReader.readAsDataURL(file[0]);
            }
            // else{
            //     preview.setAttribute('src', path);
            // }
        }
        }
        </script>

    </body>
    </html>