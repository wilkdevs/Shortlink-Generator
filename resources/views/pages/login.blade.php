@extends('layouts.layout-main')

@section('content')
    <main class="login-page" style="background-image: url({{ isset($settings['backgroundImage']) ? $settings['backgroundImage'] : $settings['backgroundImageDefault'] }});">
        <div class="login-card">
            <div class="logo-container">
                <a href="/">
                    <img src="{{ isset($settings['logoImage']) ? $settings['logoImage'] : '' }}" class="logo-img" alt="Company Logo" />
                </a>
            </div>

            <h1 class="login-title">Admin Panel</h1>

            <div class="login-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email" placeholder="Enter your email" class="form-input" />
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" placeholder="••••••••••••" class="form-input" />
                </div>

                <p class="status-message" id="loading-text" style="display: none;">Loading...</p>
                <p class="status-message error-message" id="error-message"></p>

                <button id="button-form-submit" class="login-btn">Sign In</button>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttonSubmit = document.getElementById('button-form-submit');
            const loadingText = document.getElementById('loading-text');
            const errorMessage = document.getElementById('error-message');

            if (buttonSubmit) {
                buttonSubmit.addEventListener('click', onLogin);
            }

            function onLogin() {
                loadingText.style.display = 'block';
                errorMessage.textContent = '';

                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const csrfToken = document.querySelector('input[name="_token"]').value;
                const url = '/admin/login';
                const data = {
                    email: email,
                    password: password
                };

                const xhr = new XMLHttpRequest();
                xhr.open('POST', url);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

                xhr.onload = function () {
                    loadingText.style.display = 'none';

                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.status === true) {
                            errorMessage.textContent = response.message;
                            window.location.href = "/admin";
                        } else {
                            errorMessage.textContent = response.message;
                        }
                    } else if (xhr.status === 404) {
                        errorMessage.textContent = 'Akun tidak ditemukan!';
                    } else {
                        errorMessage.textContent = 'Gagal! Silahkan coba kembali atau refresh halaman.';
                        console.error('Request failed. Returned status of ' + xhr.status);
                    }
                };

                xhr.onerror = function() {
                    loadingText.style.display = 'none';
                    errorMessage.textContent = 'Koneksi gagal. Periksa koneksi internet Anda.';
                };

                xhr.send(JSON.stringify(data));
            }
        });
    </script>
@endsection
