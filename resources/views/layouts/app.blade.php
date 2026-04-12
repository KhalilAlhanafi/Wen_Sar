<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'وين صار') }}</title>
    
    <!-- Scripts & Styles -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 antialiased font-sans">
    <header class="bg-brand-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2">
                    <a href="{{ url('/') }}" class="flex items-center">
                        <img src="{{ asset('images/full logo.jpg') }}" alt="وين صار" class="h-14 w-auto">
                    </a>
                </div>
                
                <nav class="hidden md:flex space-x-reverse space-x-8">
                    <a href="{{ url('/') }}" class="text-brand-green font-bold hover:opacity-80">الرئيسية</a>
                    <a href="#" class="text-gray-600 hover:text-brand-green">عن المشروع</a>
                    <a href="#" class="text-gray-600 hover:text-brand-green">تواصل معنا</a>
                </nav>

                <div class="flex items-center gap-4">
                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-brand-green font-bold focus:outline-none">
                                {{ Auth::user()->name }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-xl border z-50 py-2">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-50">لوحة التحكم</a>
                                <a href="{{ route('owner.businesses.index') }}" class="block px-4 py-2 text-brand-green font-bold hover:bg-gray-50 border-t border-gray-50">إدارة منشآتي</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-right block px-4 py-2 text-red-600 hover:bg-gray-50">تسجيل الخروج</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-brand-green hover:opacity-80">تسجيل الدخول</a>
                        <a href="{{ route('register') }}" class="bg-brand-green text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-sm">إنشاء حساب</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="bg-brand-green text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-right">
                <div>
                    <h3 class="text-xl font-bold mb-4">وين صار</h3>
                    <p class="text-gray-300">دليلك الشامل في دمشق وسوريا. نساعدك في الوصول إلى أفضل الخدمات والمحال التجارية.</p>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">روابط سريعة</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">الأسئلة الشائعة</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">سياسة الخصوصية</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">شروط الاستخدام</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4">تابعنا</h3>
                    <div class="flex justify-center md:justify-start gap-4">
                        <a href="#" class="text-gray-300 hover:text-white">Facebook</a>
                        <a href="#" class="text-gray-300 hover:text-white">Instagram</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 mt-8 pt-8 text-center text-gray-400">
                &copy; {{ date('Y') }} وين صار. جميع الحقوق محفوظة.
            </div>
        </div>
    </footer>
</body>
</html>
