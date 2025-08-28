<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($metatag) ? $metatag['title'] : env('APP_NAME') }}</title>
    <meta name="title" content="{{ isset($metatag) ? $metatag['title'] : env('APP_NAME') }}">
    <meta name="description" content="{{ isset($metatag) ? $metatag['desc'] : env('APP_DESC') }}">
    <meta name="keywords" content="{{ isset($metatag) ? $metatag['keyword'] : env('APP_KEYWORD') }}">
    <link rel="icon" type="image/png" href="{{ isset($settings['faviconImage']) ? $settings['faviconImage'] : $settings['faviconImageDefault'] }}">
    <link rel="canonical" href="{{ url()->full() }}">

    <link rel="stylesheet" href="/css/index.css?v=15">
    <link rel="stylesheet" href="/css/notify.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
<body>

    <header class="navbar">
        <div class="container">
            <div class="logo">{{ $settings["websiteName"] }}</div>
            <nav class="nav-links">
                <a href="#features">Features</a>
                <a href="#about">About Us</a>
            </nav>

            @if (auth()->check())
                <button class="btn dashboard-btn" id="login-btn">Dashboard</button>
            @else
                <button class="btn login-btn" id="login-btn">Log in</button>
            @endif

            <button class="menu-toggle">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </header>

    <main class="hero">
        <div class="container">
            <h1 class="hero-title">Make Every Link Work for You.</h1>
            <p class="hero-subtitle">Say goodbye to long, messy URLs. Create professional, trackable short links to gain insights and reach your audience, easily and for free.</p>

            <div class="shorten-container">
                <div class="shorten-form">
                    <input type="text" placeholder="Paste your long URL here" class="url-input" />
                    <button class="btn btn-action">&rarr;</button>
                </div>

                <div class="advanced-options">
                    <input type="checkbox" id="advanced" class="checkbox" />
                    <label for="advanced">Show advanced options</label>
                </div>

                @if (auth()->check())
                    <div class="advanced-form" id="advanced-form">
                        <form id="advanced-link-form" action="/admin/link/create" method="post">
                            @csrf
                            <input type="hidden" name="long_url" id="advanced-url-input">
                            <div class="form-fields-grid">
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="custom-link-checkbox" name="is_custom_link">
                                        <label class="form-check-label" for="custom-link-checkbox">
                                            Custom Link
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group" id="link-length-group">
                                    <label for="link_length">Link Length:</label>
                                    <input type="number" id="link_length" name="short_url_length" min="1" max="100" value="6" class="form-control">
                                </div>
                                <div class="form-group" id="custom-link-group" style="display: none;">
                                    <label for="custom_short_url">Custom Short URL:</label>
                                    <input type="text" id="custom_short_url" name="custom_short_url" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <input type="text" id="title" name="title" value="-" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <section class="features-section" id="features">
        <div class="container">
            <h2>Why {{ $settings["websiteName"] }}?</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <i class="fa-solid fa-chart-line icon"></i>
                    <h3>Analytics</h3>
                    <p>Track clicks, referrers, and locations to understand your audience better.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-star icon"></i>
                    <h3>Custom Links</h3>
                    <p>Create branded, memorable short links that stand out from the crowd.</p>
                </div>
                <div class="feature-card">
                    <i class="fa-solid fa-lock icon"></i>
                    <h3>Secure & Reliable</h3>
                    <p>Our platform is built for security and offers 99.9% uptime.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="about-section" id="about">
        <div class="container">
            <h2>About Us</h2>
            <p>{{ $settings["websiteName"] }} is a modern, open-source link management platform designed for developers and marketers. Our mission is to provide a fast, secure, and feature-rich solution for shortening and managing URLs. We believe in simplicity and powerful tools that help you achieve your goals.</p>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-links">
                    <a href="#">Terms of Service</a>
                    <a href="#">Privacy Policy</a>
                    <a href="#">Contact</a>
                </div>
                <div class="copyright">
                    Ver. 2.7.101 Copyright © 2025 {{ $settings["websiteName"] }}
                </div>
            </div>
        </div>
    </footer>

    <script src="/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
    <script src="/js/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/utils.js"></script>
    <script src="js/index.js?v=16"></script>

    <script>
    fetch('https://api.ipify.org?format=json')
        .then(response => response.json())
        .then(data => {
            console.log("Your public IP is:", data.ip);
        })
        .catch(err => console.error("Failed to get IP:", err));
    </script>

    @if(session()->has('success'))
        <script type="text/javascript">
            $(document).ready(function() {
                $.notify('{{ session('success') }}', 'success');
            });
        </script>
    @endif

    @if(session()->has('failed') || session()->has('error'))
        <script type="text/javascript">
            $(document).ready(function() {
                $.notify('{{ session('failed') ?? session('error') }}', 'error');
            });
        </script>
    @endif

</body>
</html>
