<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    @livewireStyles

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <div class="flex">
            <div class="w-64 bg-indigo-800 text-white min-h-screen">
                @include('components.sidebar')
            </div>
            
            <div class="flex-1">
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $header ?? 'Dashboard' }}
                        </h1>
                        <div>
                            <span class="text-gray-600">Welcome, Admin</span>
                        </div>
                    </div>
                </header>

                <main>
                    <div class="py-6">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            {{ $slot }}
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    @livewireScripts
    
    <!-- Livewire Debug Helper -->
    @if(config('app.debug'))
    <script>
        document.addEventListener('livewire:load', function () {
            console.log('Livewire initialized');
            
            Livewire.on('error', function (message) {
                console.error('Livewire Error:', message);
            });
            
            // Log Livewire component updates
            Livewire.hook('message.processed', (message, component) => {
                console.log('Component updated:', component.fingerprint.name, 'Data:', message.response.effects.data);
            });
            
            // Log Livewire component errors
            Livewire.hook('message.failed', (message, component) => {
                console.error('Livewire component error:', message, component);
            });
        });
    </script>
    @endif
</body>
</html>