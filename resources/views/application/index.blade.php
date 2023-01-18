@extends("layouts.default")

@section('title', "Applications")

@section('content')
    <div
        class="relative flex items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0"
    >
        <div class="mx-auto">
            <div class="flex justify-center">
                @foreach($tenants as $tenant)
                    <a
                        class="uppercase p-4 m-2 w-96 rounded p-2 hover:shadow-2xl dark:bg-warmGray-500"
                        href="{{ route("tenants.show", [ 'tenant' => $tenant->id]) }}"
                    >
                        <h2 class="text-4xl text-center">
                            {{ $tenant->id }}
                        </h2>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
