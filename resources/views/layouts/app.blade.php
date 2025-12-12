<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mapala Senja - Polinema Kediri')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #EAB308 0%, #CA8A04 50%, #854D0E 100%);
        }
        .gradient-bg-dark {
            background: linear-gradient(135deg, #1F2937 0%, #111827 100%);
        }
        .section-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #EAB308;
            margin: 12px auto 0;
        }
        .logo-shadow {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
        }
        .text-shadow {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">
    
    @include('partials.navbar')

    @yield('content')

    @include('partials.footer')

    <!-- Smooth Scroll Script -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @yield('scripts')
    <!-- Toast Notification -->
@if(session('success') || session('error') || session('info'))
<div id="toast" class="fixed top-24 right-4 z-50 transform translate-x-0 transition-all duration-500 ease-in-out">
    <div class="bg-white rounded-lg shadow-2xl border-l-4 {{ session('success') ? 'border-green-500' : (session('error') ? 'border-red-500' : 'border-blue-500') }} p-4 flex items-center space-x-3 min-w-[300px]">
        @if(session('success'))
            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-800">Berhasil!</p>
                <p class="text-sm text-gray-600">{{ session('success') }}</p>
            </div>
        @elseif(session('error'))
            <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-800">Error!</p>
                <p class="text-sm text-gray-600">{{ session('error') }}</p>
            </div>
        @else
            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-800">Info</p>
                <p class="text-sm text-gray-600">{{ session('info') }}</p>
            </div>
        @endif
        <button onclick="document.getElementById('toast').remove()" class="flex-shrink-0 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</div>

<script>
    // Auto hide toast after 4 seconds
    setTimeout(function() {
        const toast = document.getElementById('toast');
        if (toast) {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 500);
        }
    }, 4000);
</script>
@endif
</body>
</html>