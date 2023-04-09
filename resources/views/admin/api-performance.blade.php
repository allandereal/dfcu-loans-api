<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Outstanding Loans Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="antialiased">
<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            @auth
                <a href="/docs" class="mx-4 dark:text-white border border-gray-400 rounded-lg px-4 py-1">View docs</a>
                <span class="dark:text-white">{{ auth()->user()->name }}</span>
                <a href="{{ url('/logout') }}"
                   class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="text-blue-700 hover:text-blue-500 ml-2">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center">
            <img src="{{ asset('images/dfcu-Bank-logo.png') }}" class="h-16 w-auto bg-gray-100 dark:bg-gray-900" />
        </div>
        <div class="flex justify-center">
            <h1 class="w-auto text-2xl bg-gray-100 dark:bg-gray-900 dark:text-white"> Outstanding Loans API Dashboard</h1>
        </div>

        <div class="mt-16">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                <div class="flex flex-col items-center space-y-4 scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                    <div class="flex justify-between space-x-4">
                        <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>

                        <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Failed Validations</h2>
                    </div>
                    <h1 class="font-bold text-6xl dark:text-white">{{ $failedValidations }}</h1>
                </div>

                @foreach($groupedApiRequests as $groupedApiRequest)
                    <div class="flex flex-col items-center space-y-4 scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div class="flex justify-between space-x-4">
                            <div @class([
                                    'h-16 w-16 flex items-center justify-center rounded-full',
                                    'bg-green-50 dark:bg-green-800/20' => $groupedApiRequest->status === 'positive',
                                    'bg-orange-50 dark:bg-orange-800/20' => $groupedApiRequest->status === 'negative',
                                    'bg-red-50 dark:bg-red-800/20' => $groupedApiRequest->status === 'invalid',
                                 ])
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    @class([
                                       'stroke-green-500' => $groupedApiRequest->status === 'positive',
                                       'stroke-orange-500' => $groupedApiRequest->status === 'negative',
                                       'stroke-red-500' => $groupedApiRequest->status === 'invalid',
                                       'w-7 h-7'
                                    ])
                                >
                                    @if($groupedApiRequest->status === 'positive')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @elseif($groupedApiRequest->status === 'negative')
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.57-.598-3.75h-.152c-3.196 0-6.1-1.249-8.25-3.286zm0 13.036h.008v.008H12v-.008z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @endif
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ ucfirst($groupedApiRequest->status) }} Requests</h2>
                        </div>
                        <h1 class="font-bold text-6xl dark:text-white">{{ $groupedApiRequest->number }}</h1>
                    </div>
                @endforeach
            </div>

            <div class="text-center flex space-x-4 pt-6">
                <button onclick="generateAccessToken()" class="bg-gray-800 text-white px-4 py-1 rounded-lg">Generate Access Token</button>
                <span id="api-access-token" class="text-green-600"></span>
            </div>

        </div>
    </div>
</div>
<script>
    function generateAccessToken(){
        fetch('/admin/generate-api-token')
            .then(response => response.json())
            .then(data => {
                document.getElementById('api-access-token').innerText = data;
            })
    }
</script>
</body>
</html>
