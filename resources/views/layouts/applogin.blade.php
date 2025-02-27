<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{-- themes --}}
    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('berry/dist/assets/images/favicon.svg') }} " type="image/x-icon" />
    <!-- [Page specific CSS] start -->
    <link href="{{ asset('berry/dist/assets/css/plugins/animate.min.css') }} " rel="stylesheet" type="text/css" />
    <!-- [Page specific CSS] end -->
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        id="main-font-link" />
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('berry/dist/assets/fonts/tabler-icons.min.css') }} " />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('berry/dist/assets/fonts/feather.css') }} " />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('berry/dist/assets/fonts/fontawesome.css') }} " />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('berry/dist/assets/fonts/material.css') }} " />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('berry/dist/assets/css/style.css') }} " id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('berry/dist/assets/css/style-preset.css') }} " />

    <link rel="stylesheet" href="{{ asset('berry/dist/assets/css/landing.css') }} " />
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div id="app">
        @yield('content')
        </main>
    </div>

    <!-- Required Js -->
    <script src="{{ asset('berry/dist/assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('berry/dist/assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('berry/dist/assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('berry/dist/assets/js/icon/custom-font.js') }}"></script>
    <script src="{{ asset('berry/dist/assets/js/script.js') }}"></script>
    <script src="{{ asset('berry/dist/assets/js/theme.js') }}"></script>
    <script src="{{ asset('berry/dist/assets/js//plugins/feather.min.js') }}"></script>

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



    <!-- [Page Specific JS] start -->
    <!-- Apex Chart -->
    <script src="{{ asset('berry/dist/assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('berry/dist/assets/js/pages/dashboard-default.js') }}"></script>

    <!-- [Page Specific JS] end -->
</body>

</html>
