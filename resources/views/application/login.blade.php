@extends("layouts.default")

@section('title', "Authentication")

@section('content')
    <div class="mx-auto max-w-screen-md absolute transform translate-y-1/2 left-1/2 -translate-x-1/2">
        <h1 class="text-center text-orange-700 font-bold text-7xl hidden">Welcome to Logiweb </h1>
        <form class="bg-white w-96 p-7 rounded-xl min-w-[500px] shadow-xl mt-12 max-w-screen-sm space-y-2" method="post"
              action="{{ route('sign-in') }}">
            @csrf
            <div class="mb-6">
                <label class="block mb-2 text-orange-500" for="email">Email</label>
                <input
                    class="w-full bg-gray-100 rounded shadow p-2 text-orange-500 border-b-2 border-orange-500 outline-none focus:bg-gray-300"
                    type="text"
                    name="email"
                    id="email"
                />
                @error('email')
                <span class="text-orange-500 inline-block">{{ $message }}</span>¬
                @enderror
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-orange-500" for="password">Password</label>
                <input
                    class="w-full bg-gray-100 rounded shadow p-2 text-orange-500 border-b-2 border-orange-500 outline-none focus:bg-gray-300"
                    type="password"
                    name="password"
                    id="password"
                />
                @error('password')
                <span class="text-orange-500 inline-block">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <button
                    class="w-full shadow-xl hover:shadow transition uppercase bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 mb-6 rounded"
                    type="submit"
                >
                    Sign In
                </button>
            </div>
        </form>
    </div>
@endsection
