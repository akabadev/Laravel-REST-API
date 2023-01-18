<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', 'Hello') | Logiweb
    </title>

    @section('styles')
        <link href="/assets/css/app.css" rel="stylesheet">
    @show
</head>
<body class="antialiased dark">
<div class="dark:text-warmGray-50 bg-warmGray-100 dark:bg-warmGray-700">
    <div class="container mx-auto">
        @auth
            <div class="flex justify-between py-7">
                <h1 class="text-4xl">
                    {{ auth()->user()->name }} <br/>
                    <span class="text-sm">({{ auth()->user()->email }})</span>
                </h1>
                <div>
                    <a class="flex bg-orange-500 p-2 rounded-xl" href="{{ route('sign-out') }}">
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor"
                                  d="M16.56,5.44L15.11,6.89C16.84,7.94 18,9.83 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12C6,9.83 7.16,7.94 8.88,6.88L7.44,5.44C5.36,6.88 4,9.28 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12C20,9.28 18.64,6.88 16.56,5.44M13,3H11V13H13"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endauth
        @section('content')
            <h1 class="text-10xl text-bold text-center">Logiweb | by Up.coop </h1>
        @show
    </div>
</div>
</body>
</html>
