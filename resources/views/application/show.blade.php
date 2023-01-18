@extends("layouts.default")

@section('title', "Applications")

@section('content')
    <div
        class="flex flex-col items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0"
    >
        <div class="sm:px-6 lg:px-8 space-y-10">
            <div class="flex justify-center flex-col pt-8 sm:justify-start sm:pt-0">
                <a class="p-2 rounded" href="{{ route("tenants.index") }}">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor"
                              d="M2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12M18,11H10L13.5,7.5L12.08,6.08L6.16,12L12.08,17.92L13.5,16.5L10,13H18V11Z"/>
                    </svg>
                </a>
                <h1 class="text-7xl text-center">
                    Extranet {{ $tenant->id }}
                </h1>
            </div>
            <div class="">
                <div class="mt-3 flex gap-2 flex-col">
                    @foreach($tenant->domains as $domain)
                        <a
                            href="http://{{ $domain->domain  }}"
                            target="_blank"
                            class="text-2xl flex justify-items-start items-center transition bg-warmGray-600 hover:shadow-md hover:bg-warmGray-500 rounded"
                        >
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path
                                    fill="currentColor"
                                    d="M12 6.46C11.72 6.46 11.44 6.56 11.22 6.78L6.78 11.22C6.35 11.65 6.35 12.35 6.78 12.78L11.22 17.22C11.65 17.65 12.35 17.65 12.78 17.22L17.22 12.78C17.65 12.35 17.65 11.65 17.22 11.22L12.78 6.78C12.56 6.56 12.28 6.46 12 6.46Z"
                                />
                            </svg>
                            <span>{{ $domain->domain }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
