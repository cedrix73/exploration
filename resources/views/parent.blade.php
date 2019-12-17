<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('titre')</title>
</head>
<body>
    <p>@yield('contenu')</p>
</body>
</html>
