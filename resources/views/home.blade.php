<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kazeer - Solusi Pemesanan Makanan Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Navbar -->
    <nav class="fixed w-full z-20 top-0 left-0 border-b border-gray-200 bg-white/80 backdrop-blur-md">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-blue-600">Kazeer</span>
            </a>
            <div class="flex md:order-2">
                @guest
                    <!-- Tombol Login jika belum login -->
                    <a href="{{ route('login') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0">
                        Login
                    </a>
                @else
                    <!-- Dropdown Avatar setelah login -->
                    <div class="relative">
                        <button 
                            type="button" 
                            class="flex items-center text-sm bg-gray-200 rounded-full focus:ring-4 focus:ring-blue-300"
                            id="user-menu-button"
                            aria-expanded="false"
                            data-dropdown-toggle="user-dropdown"
                            data-dropdown-placement="bottom"
                        >
                            <span class="sr-only">Open user menu</span>
                            <img 
                                class="w-10 h-10 rounded-full" 
                                src="{{ Auth::user()->avatar && filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL) ? Auth::user()->avatar : asset('storage/image/default-avatar.png') }}" 
                                alt="User avatar"
                            >
                        </button>
    
                        <!-- Dropdown menu -->
                        <div 
                            class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" 
                            id="user-dropdown"
                        >
                            <div class="px-4 py-3">
                                <span class="block text-sm text-gray-900 dark:text-white">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="block text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ Auth::user()->email }}
                                </span>
                            </div>
                            <ul class="py-2" aria-labelledby="user-menu-button">
                                @if(Auth::user()->role == 'merchant')
                                    <li>
                                        <a 
                                            href="{{ route('merchants.dashboard') }}" 
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >
                                            Dashboard Merchant
                                        </a>
                                    </li>
                                @endif
    
                                @if(Auth::user()->role == 'admin')
                                    <li>
                                        <a 
                                            href="{{ route('admin.dashboard') }}" 
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >
                                            Admin Dashboard
                                        </a>
                                    </li>
                                @endif
    
                                <li>
                                    <a 
                                        href="{{ route('profile.edit') }}" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                    >
                                        Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                        >
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="pt-24 pb-12 px-4 mx-auto max-w-screen-xl text-center">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl">
            Revolusi Pemesanan Makanan untuk Restoran Modern
        </h1>
        <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48">
            Kazeer merubah cara restoran mengelola pemesanan makanan dengan teknologi barcode pintar dan antarmuka pengguna yang intuitif.
        </p>
        <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            <a href="#features" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300">
                Pelajari Lebih Lanjut
            </a>
        </div>
    </header>

    <!-- Fitur Utama -->
    <section id="features" class="bg-white py-16">
        <div class="max-w-screen-xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12">Fitur Unggulan Kazeer</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-100 p-6 rounded-lg text-center">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2V6H5v2zm14 0h2V6h-2v2zM5 16h2v-2H5v2zm14 0h2v-2h-2v2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Scan Barcode Mudah</h3>
                    <p class="text-gray-600">Proses pemesanan cepat dengan menscan barcode meja yang disediakan.</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg text-center">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Manajemen Restoran Lengkap</h3>
                    <p class="text-gray-600">Kelola kategori, jenis makanan, dan transaksi dengan mudah.</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg text-center">
                    <div class="flex justify-center mb-4">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Fitur Keranjang Modern</h3>
                    <p class="text-gray-600">Tambah, hapus, dan kelola pesanan dengan antarmuka yang intuitif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo & Makanan Favorit -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-3xl font-bold mb-6">Promo Menarik</h2>
                    <p class="text-gray-600 mb-6">Dapatkan berbagai promo menarik dari restoran yang bekerja sama dengan Kazeer.</p>
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <h3 class="font-semibold text-lg">Diskon 20% Setiap Senin</h3>
                            <p class="text-gray-500">Nikmati diskon spesial setiap awal pekan</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md">
                            <h3 class="font-semibold text-lg">Gratis Ongkir</h3>
                            <p class="text-gray-500">Untuk pemesanan di atas Rp 100.000</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-6">Makanan Favorit</h2>
                    <p class="text-gray-600 mb-6">Temukan berbagai pilihan makanan favorit dari berbagai restoran.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-lg shadow-md text-center">
                            <img src="{{ asset('storage/image/nasi-goreng.jpg') }}" alt="Makanan Favorit" class="mx-auto mb-4 rounded-lg w-[200px]">
                            <h3 class="font-semibold">Nasi Goreng</h3>
                            <p class="text-gray-500">Rp 25.000</p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md text-center">
                            <img src="{{ asset('storage/image/sate-ayam.jpg') }}" alt="Makanan Favorit" class="mx-auto mb-4 rounded-lg w-[200px]">
                            <h3 class="font-semibold">Sate Ayam</h3>
                            <p class="text-gray-500">Rp 35.000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Kerja -->
    <section class="bg-white py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12">Cara Kerja Kazeer</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="bg-gray-100 p-6 rounded-lg">
                    <div class="text-5xl font-bold text-blue-600 mb-4">1</div>
                    <h3 class="font-semibold mb-2">Scan Barcode</h3>
                    <p class="text-gray-600">Scan barcode meja di restoran</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg">
                    <div class="text-5xl font-bold text-blue-600 mb-4">2</div>
                    <h3 class="font-semibold mb-2">Pilih Makanan</h3>
                    <p class="text-gray-600">Jelajahi menu dan pilih makanan</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg">
                    <div class="text-5xl font-bold text-blue-600 mb-4">3</div>
                    <h3 class="font-semibold mb-2">Tambah Keranjang</h3>
                    <p class="text-gray-600">Masukkan pesanan ke keranjang</p>
                </div>
                <div class="bg-gray-100 p-6 rounded-lg">
                    <div class="text-5xl font-bold text-blue-600 mb-4">4</div>
                    <h3 class="font-semibold mb-2">Bayar & Nikmati</h3>
                    <p class="text-gray-600">Selesaikan pembayaran</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12">Apa Kata Mereka Tentang Kazeer</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="italic mb-4">"Kazeer sangat memudahkan proses pemesanan di restoran kami. Pelanggan senang dengan kemudahannya!"</p>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('storage/image/male.jpg') }}" alt="Pemilik Restoran" class="rounded-full mr-4 w-[200px] h-[200px]">
                        <div>
                            <h3 class="font-semibold">Budi Santoso</h3>
                            <p class="text-gray-500">Pemilik Restoran</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="italic mb-4">"Antarmuka yang modern dan mudah digunakan. Saya jadi lebih suka memesan makanan!"</p>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('storage/image/male.jpg') }}" alt="Pengguna" class="rounded-full mr-4 w-[200px] h-[200px]">
                        <div>
                            <h3 class="font-semibold">Maria Ulfa</h3>
                            <p class="text-gray-500">Pengguna Kazeer</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <p class="italic mb-4">"Fitur manajemen pesanan yang luar biasa. Membantu kami mengoptimalkan layanan."</p>
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('storage/image/male.jpg') }}" alt="Manajer Restoran" class="rounded-full mr-4 w-[200px] h-[200px]">
                        <div>
                            <h3 class="font-semibold">Ahmad Rizki</h3>
                            <p class="text-gray-500">Manajer Restoran</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Harga & Paket -->
    <section class="bg-white py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-12">Pilih Paket Kazeer</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-100 p-6 rounded-lg border-2 border-transparent hover:border-blue-500 transition-all duration-300">
                    <h3 class="text-xl font-semibold mb-4">Basic</h3>
                    <p class="text-4xl font-bold text-blue-600 mb-4">Gratis</p>
                    <ul class="mb-6 space-y-3 text-left text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Maksimal 2 Meja
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            10 Produk Makanan
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Laporan Dasar
                        </li>
                    </ul>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Pilih Paket Basic
                    </button>
                </div>

                <div class="bg-gray-100 p-6 rounded-lg border-2 border-blue-500 transform scale-105 shadow-lg">
                    <div class="absolute top-0 right-0 bg-blue-600 text-white px-4 py-1 rounded-bl-lg">
                        Recommended
                    </div>
                    <h3 class="text-xl font-semibold mb-4">Pro</h3>
                    <p class="text-4xl font-bold text-blue-600 mb-4">
                        Rp 199.000 
                        <span class="text-sm block text-gray-500">per bulan</span>
                    </p>
                    <ul class="mb-6 space-y-3 text-left text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Maksimal 10 Meja
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            50 Produk Makanan
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Laporan Lengkap
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Dukungan Prioritas
                        </li>
                    </ul>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Pilih Paket Pro
                    </button>
                </div>

                <div class="bg-gray-100 p-6 rounded-lg border-2 border-transparent hover:border-blue-500 transition-all duration-300">
                    <h3 class="text-xl font-semibold mb-4">Enterprise</h3>
                    <p class="text-4xl font-bold text-blue-600 mb-4">
                        Custom 
                        <span class="text-sm block text-gray-500">hubungi kami</span>
                    </p>
                    <ul class="mb-6 space-y-3 text-left text-gray-600">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Unlimited Meja
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Unlimited Produk Makanan
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Laporan Komprehensif
                        </li>
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Dukungan Khusus
                        </li>
                    </ul>
                    <button class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors">
                        Hubungi Sales
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA (Call to Action) -->
    <section class="bg-blue-600 text-white py-16">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Siap Mulai dengan Kazeer?</h2>
            <p class="text-xl mb-8">Revolusikan sistem pemesanan makanan restoran Anda hari ini!</p>
            <div class="flex justify-center space-x-4">
                <a href="#" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                    Coba Gratis
                </a>
                <a href="#" class="border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-screen-xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Kazeer</h2>
            <p class="text-gray-400 mb-8">Solusi pemesanan makanan modern untuk restoran masa kini</p>
            <div class="flex justify-center space-x-4 mb-8">
                <a href="#" class="text-gray-400 hover:text-white">Tentang Kami</a>
                <a href="#" class="text-gray-400 hover:text-white">Kontak</a>
                <a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a>
                <a href="#" class="text-gray-400 hover:text-white">Syarat & Ketentuan</a>
            </div>
            <div class="flex justify-center space-x-6 mb-8">
                <a href="#" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.148 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.148-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98C0 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 24 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.072-1.689.072-4.948 0-3.259-.013-3.667-.072-4.947-.197-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 10-.001 2.88 1.44 1.44 0 00.001-2.88z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.954 4.569a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.38 4.482C7.691 8.094 4.066 6.13 1.64 3.161a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.061a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913a5.885 5.885 0 001.384 2.126A5.868 5.868 0 004.14 23.37c.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558a5.898 5.898 0 002.126-1.384 5.86 5.86 0 001.384-2.126c.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913a5.89 5.89 0 00-1.384-2.126A5.847 5.847 0 0019.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.415 2.227.056 1.266.07 1.646.07 4.85s-.014 3.585-.07 4.85c-.56 1.158-.25 1.805-.415 2.227a3.81 3.81 0 01-.896 1.382c-.42.419-.824.679-1.381.896-.422.164-1.065.36-2.227.415-1.266.056-1.646.07-4.85.07s-3.585-.014-4.85-.07c-1.158-.055-1.805-.251-2.227-.415a3.716 3.716 0 01-1.382-.896c-.419-.42-.679-.824-.896-1.381-.164-.422-.36-1.065-.415-2.227-.056-1.266-.071-1.646-.071-4.85s.015-3.585.071-4.85c.055-1.158.251-1.805.415-2.227a3.716 3.716 0 01.896-1.382c.42-.419.824-.679 1.382-.896.422-.164 1.065-.36 2.227-.415 1.265-.056 1.646-.071 4.85-.071zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 10-.001 2.88 1.44 1.44 0 00.001-2.88z"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="mt-8 text-center text-gray-500 border-t border-gray-700 pt-4 mx-auto">
            © 2024 Kazeer. Hak Cipta Dilindungi Undang-Undang.
        </div>        
    </div>
</footer>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userMenuButton = document.getElementById('user-menu-button');
        const userDropdown = document.getElementById('user-dropdown');

        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', function() {
                userDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                    userDropdown.classList.add('hidden');
                }
            });
        }
    });
</script>
</body>
</html>