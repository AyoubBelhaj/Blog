<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$page_title}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="{{asset('blogtheme/css/styles.css')}}" rel="stylesheet" />
    <style>
        .invalid-feedback{
            display: block;
        }
    </style>

</head>
<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{url('/')}}">{{ $blog_name }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('latest') }}">Latest</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('contact') }}">Contact</a></li>
                    
                    @guest
                            <li class="nav-item">
                                <a class="nav-link "  href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="col-lg-6">
                        <div class="page-title">
                            <h1>Contact Us</h1>
                        </div>
                
                @if (Session::has('flash_message'))
                    <div class="alert alert-success">{{ Session::get('flash_message') }}</div>
                @endif
            <form method="POST" action="{{url('contact')}}">
                {{ csrf_field() }}
                
                <div class="form-group">
                    <label >Full Name : </label>
                    <input type="text" class="form-control" name="name">
                    @if($errors->has('name'))
                     <small class="form-text invalid-feedback">{{ $errors->first('name') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label >Email Address : </label>
                    <input type="text" class="form-control" name="email">
                    @if ($errors->has('email'))
                        <small class="form-text invalid-feedback">{{ $errors->first('email') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label >Message : </label>
                    <textarea name="message" class="form-control"></textarea>
                    @if ($errors->has('message'))
                        <small class="form-text invalid-feedback">{{ $errors->first('message') }}</small>
                    @endif
                </div>
                <button class="btn btn-primary">Submit</button>
            </form>
            </div>
        </div>
    </div>
      </div>
    </div>
</body>
</html>