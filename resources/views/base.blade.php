<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <style>
        /* Permet de pousser le footer en bas */
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1; /* Prend tout l'espace restant */
        }
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }
    </style>
</head>
<body>
    <main class="container my-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger text-center">
                <ul>
                    @foreach($errors->all() as $error)
                        {{ $error }} <br>
                    @endforeach
                </ul>
                
            </div>
        @endif

        {{-- @yield('accueil') --}}

        @yield('header')

        @yield('content')

        @yield('back')
    </main>

    <footer class="bg-dark text-white text-center py-3">
        @yield('footer')
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
