<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">

    <title>{{ isset($metatag) ? $metatag['title'] : env('APP_NAME') }}</title>
    <meta name="keywords" content="{{ isset($metatag) ? $metatag['keyword'] : env('APP_KEYWORD') }}">
    <meta name="description" content="{{ isset($metatag) ? $metatag['desc'] : env('APP_DESC') }}">
    <link rel="icon" type="image/png" href="{{ isset($settings['faviconImage']) ? $settings['faviconImage'] : $settings['faviconImageDefault'] }}">

    <link rel="stylesheet" href="/assets/css/bootstrap.min.css" />

    <link rel="stylesheet" href="/assets/css/all.css">

    <link rel="stylesheet" href="/assets/css/animate.min.css" />

    <link rel="stylesheet" href="/css/tailwind.min.css" />

    <script src="/assets/js/jquery.min.js"></script>

    <script src="/assets/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="/css/index.css" />

</head>
