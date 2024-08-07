<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            <div class="pb-6">
                <button id="export-button" class="bg-blue-600 text-white rounded px-4 py-3 mr-4" type="button">
                    Start Export
                </button>
            </div>
            {{ $slot }}
        </main>
    </div>
</body>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        window.Echo.private('App.Models.User.' + {{ auth()->id() }})
            .listen('ExportFinishedEvent', (event) => {
                let location = document.getElementsByTagName('main')[0];
                let div = document.createElement('div');
                div.style.width = '100%';
                div.style.height = '32px';
                div.style.textAlign = 'center';
                div.style.lineHeight = '32px';
                div.style.background = '#44ff44';
                div.innerHTML = 'SUCCESS: Your export is finished. You can download it <a href="' + event
                    .file_path + '">here</a>.';
                location.insertBefore(div, location.firstChild);
            });

        window.Echo.channel('system-maintenance')
            .listen('SystemMaintenanceEvent', (event) => {
                let location = document.getElementsByTagName('main')[0];
                let div = document.createElement('div');
                div.style.width = '100%';
                div.style.height = '32px';
                div.style.textAlign = 'center';
                div.style.lineHeight = '32px';
                div.style.background = '#ffab44';
                div.innerHTML = 'WARNING: The system will go down for maintenance at ' + event.time + '.';
                location.insertBefore(div, location.firstChild);
            });
    });

    var button = document.getElementById('export-button');

    button.addEventListener('click', function() {
        axios.post('/start-export');
    });
</script>

</html>
