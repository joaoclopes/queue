<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
</head>
<body>
    {{-- Inclui o header --}}
    @include('partials.header')

    <div class="container">
        {{-- Conteúdo dinâmico --}}
        @yield('content')
    </div>
</body>
</html>
