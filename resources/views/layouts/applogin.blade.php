<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}


    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }} " type="image/x-icon" />

    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        id="main-font-link" />

    <!-- [phosphor Icons] https://phosphoricons.com/ -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" /> --}}

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }} " />

    <!-- [Feather Icons] https://feathericons.com -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }} " /> --}}

    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }} " /> --}}

    <!-- [Material Icons] https://fonts.google.com/icons -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }} " /> --}}

    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }} " id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }} " />

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    @stack('css')

</head>

<body>
    @include('layouts.partials.loader')
    @yield('content')

    <!-- Required Js -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    {{-- setting js --}}
    <script>
        layout_change('light');
    </script>

    <script>
        font_change('Roboto');
    </script>

    <script>
        change_box_container('false');
    </script>

    <script>
        layout_caption_change('true');
    </script>

    <script>
        layout_rtl_change('false');
    </script>

    <script>
        preset_change('preset-1');
    </script>

    @stack('script')
</body>

</html>
