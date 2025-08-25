<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ isset($settings['faviconImage']) ? $settings['faviconImage'] : $settings['faviconImageDefault'] }}">

    <title>{{ isset($metatag) ? $metatag['title'] : env('APP_NAME') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--  Social tags      -->
    <meta name="keywords" content="{{ isset($metatag) ? $metatag['keyword'] : env('APP_KEYWORD') }}">
    <meta name="description" content="{{ isset($metatag) ? $metatag['desc'] : env('APP_DESC') }}">

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="/assets/css/material-dashboard.min.css?v=3.1.4" rel="stylesheet" />

    <link id="pagestyle" href="/assets/css/custom.css?v=2" rel="stylesheet" />

    <link id="pagestyle" href="/css/admin.css?v=2" rel="stylesheet" />

</head>
