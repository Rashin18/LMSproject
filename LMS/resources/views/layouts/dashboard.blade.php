<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LMS Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Navbar -->
    <header class="bg-white shadow sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-indigo-600">LMS Dashboard</h1>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 text-gray-700 hover:text-black focus:outline-none">
                    <span class="font-medium">{{ Auth::user()->name }}</span>
                    <span class="text-sm text-gray-500">({{ Auth::user()->role }})</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                    </svg>
                </button>

                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg py-1 z-50"
                >
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main content -->
    <main class="py-6 px-4">
        @yield('content')
    </main>

</body>
</html>
