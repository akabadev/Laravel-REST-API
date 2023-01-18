<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title', $title) | Logiweb
    </title>

    <link href="/assets/css/app.css" rel="stylesheet">
    @section('styles')
        <link href="{{ mix("assets/css/prism.css") }}" rel="stylesheet">
    @show
</head>
<body class="antialiased ">
<div
    class="dark:text-warmGray-50 bg-warmGray-100 dark:bg-warmGray-700">
    <div class="mx-auto h-screen grid grid-cols-1 md:grid-cols-12 gap-4 overflow-hidden">
        <aside class="col-span-3 flex flex-col gap-y-3 p-2">
            <a href="{{ route('wiki') }}"
               class="flex-shrink-0 p-4 bg-orange-500 text-warmGray-50 font-bold text-center uppercase rounded-lg"
            >
                Logiweb Wiki
            </a>
            <nav class="bg-warmGray-200 p-2 rounded-xl flex-shrink-1 flex-1 flex flex-col gap-y-1">
                @foreach($pages as $page)
                    <a
                        href="{{ route('wiki', ['slug' => $page['slug']]) }}"
                        class="p-3 rounded-md {{ $page['slug'] == $slug ? "bg-orange-200" : "bg-warmGray-50" }}"
                    >
                        {{ $page['title'] }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <main class="col-span-9 text-white overflow-y-auto">
            <article class="prose lg:prose-xl">
                @section('content')
                    <h1 class="text-10xl text-bold text-center">Logiweb | by Up.coop </h1>
                @show
            </article>
        </main>
    </div>
</div>
<script src="{{ mix("assets/js/prism.js") }}"></script>
</body>
</html>
