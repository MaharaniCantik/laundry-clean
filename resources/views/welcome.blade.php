<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CuciYuk – NO.1 Laundry Express di Tangerang</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script> <script>
        // Ini script tailwind config dari Claude tadi, copy-paste di sini
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skyBg: '#D1E9F6',
                        skyMid: '#B8DCF0',
                        blueMed: '#38A1D1',
                        blueDark: '#2080B0',
                        purple: '#5D325E',
                        purpleLight: '#7A4A7B',
                        orange: '#F6921E',
                        orangeHot:'#E07E10',
                    },
                   fontFamily: {
            poppins: ['Poppins', 'sans-serif'],
          },
          keyframes: {
            fadeUp: {
              '0%':   { opacity: '0', transform: 'translateY(30px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            spinSlow: {
              '0%':   { transform: 'rotate(0deg)' },
              '100%': { transform: 'rotate(360deg)' },
            },
            float: {
              '0%,100%': { transform: 'translateY(0px)' },
              '50%':     { transform: 'translateY(-10px)' },
            },
          },
          animation: {
            fadeUp:   'fadeUp 0.7s ease both',
            fadeUp2:  'fadeUp 0.7s 0.15s ease both',
            fadeUp3:  'fadeUp 0.7s 0.3s ease both',
            fadeUp4:  'fadeUp 0.7s 0.45s ease both',
            spinSlow: 'spinSlow 12s linear infinite',
            float:    'float 3s ease-in-out infinite',
          },
        },
      },
    };
  </script>
  <style>
    * { font-family: 'Poppins', sans-serif; }

    /* Bubble decorations */
    .bubble {
      position: absolute;
      border-radius: 50%;
      background: rgba(255,255,255,0.18);
      pointer-events: none;
    }

    /* Service section backdrop */
    .services-bg {
      background-image:
        linear-gradient(rgba(56,161,209,0.72), rgba(56,161,209,0.72)),
        url('https://images.unsplash.com/photo-1545173168-9f1947eebb7f?w=1400&q=80');
      background-size: cover;
      background-position: center;
    }

    /* Subtle card lift */
    .card-hover {
      transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .card-hover:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 40px rgba(93,50,94,0.15);
    }

    /* Washing machine drum spin on hover */
    .machine-drum:hover .drum-inner {
      animation: spinSlow 4s linear infinite;
    }
    html {
    scroll-behavior: smooth;
  }
  </style>
</head>


<body x-data="{ showLogin: {{ request()->get('openLoginModal') ? 'true' : 'false' }}, showRegister: false }" class="antialiased bg-skyBg text-gray-700 overflow-x-hidden">
  @include('partials.navbar')
  <!-- ░░░ HERO ░░░ -->
  <header class="relative bg-skyBg min-h-screen flex items-center overflow-hidden px-6 md:px-16 lg:px-24 py-20">

    <!-- Decorative bubbles -->
    <div class="bubble w-64 h-64 -top-16 -left-16 opacity-40"></div>
    <div class="bubble w-40 h-40 top-1/3 right-10 opacity-30"></div>
    <div class="bubble w-24 h-24 bottom-10 left-1/3 opacity-20"></div>

    <div class="relative z-10 max-w-6xl mx-auto w-full flex flex-col md:flex-row items-center gap-12">

      <!-- LEFT: Washing machine illustration -->
      <div class="w-full md:w-5/12 flex justify-center animate-float">
        <div class="machine-drum relative w-64 h-72 md:w-80 md:h-96">
          <!-- Machine body -->
          <img src="{{ asset('images/mesincuci.png') }}" class="w-519 h-578" alt="Logo Mesincuci">
          <!-- Door ring -->
          <div class="absolute top-20 left-1/2 -translate-x-1/2 w-36 h-36 md:w-44 md:h-44 rounded-full flex items-center justify-center shadow-inner">
            <!-- Drum -->
            <div class="flex items-center justify-center relative transition-all duration-500">
            </div>
          </div>
          <!-- Bottom panel -->
          <div class="absolute bottom-5 left-6 right-6 flex gap-2 items-center">
            <div class="flex-1 h-3 bg-white/20 rounded-full"></div>
          </div>
        </div>
      </div>

      <!-- RIGHT: Copy -->
      <div  class="w-full md:w-7/12 text-center md:text-left">
        <div class="inline-block bg-orange/10 text-orange font-semibold text-sm px-4 py-1 rounded-full mb-4 animate-fadeUp">
          ✨ Layanan Terpercaya di Tangerang
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-purple leading-tight mb-5 animate-fadeUp2">
          NO.1 Laundry<br/>
          <span class="text-orange">Express</span> di<br/>
          Tangerang
        </h1>
        <p class="text-gray-500 text-base md:text-lg leading-relaxed mb-4 max-w-md mx-auto md:mx-0 animate-fadeUp3">
          Stop Numpuk Cucian! Biar CuciYuk yang Beresiin 🧺<br/>
          Layanan cepat, bersih, dan terpercaya langsung ke depan pintumu.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center md:justify-start animate-fadeUp4">
          <div class="relative inline-block text-left w-full sm:w-auto z-50">
            
            <button id="tombol-dropdown" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-orange text-white font-bold text-base px-8 py-4 rounded-full shadow-lg hover:bg-orangeHot hover:scale-105 transition-all duration-300 hover:shadow-orange/40 hover:shadow-xl">
              🧺 Laundry Sekarang
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>

            <div id="isi-dropdown" class="hidden absolute left-0 bottom-full mb-2 w-48 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">
              <a href="{{ route('order.kiloan') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">Laundry Kiloan</a>
              <a href="{{ route('order.permadani') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">Laundry Permadani</a>
              <a href="{{ route('order.setrika') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">Setrika</a>
              <a href="{{ route('order.boneka') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">Laundry Boneka</a>
              <a href="{{ route('order.gorden') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">Laundry Gordern</a>
              <a href="{{ route('order.bedcover') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">Laundry Bedcover</a>
              <a href="{{ route('order.sepatu') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50">Laundry Sepatu</a>
            </div>
          </div>
          <a href="{{ url('/#layanan') }}" class="w-full sm:w-auto text-center border-2 border-purple text-purple font-semibold text-base px-8 py-4 rounded-full hover:bg-purple hover:text-white hover:scale-105 transition-all duration-300">
            Lihat Layanan
          </a>
          
        </div>
              <!-- Stats row -->
              <div class="mt-10 flex gap-8 justify-center md:justify-start animate-fadeUp4">
                  <div class="text-center">
                    <p class="text-2xl font-black text-purple">5.000+</p>
                    <p class="text-xs text-gray-400 font-medium">Pelanggan Puas</p>
                  </div>
                  <div class="w-px bg-gray-200"></div>
                  <div class="text-center">
                    <p class="text-2xl font-black text-purple">24 Jam</p>
                    <p class="text-xs text-gray-400 font-medium">Layanan Express</p>
                  </div>
                  <div class="w-px bg-gray-200"></div>
                  <div class="text-center">
                    <p class="text-2xl font-black text-purple">4.9 ⭐</p>
                    <p class="text-xs text-gray-400 font-medium">Rating Google</p>
                  </div>
                </div>
            </div>
          </div>

    <!-- Wave divider -->
    <div id="tentang-kami"class="absolute bottom-0 left-0 right-0">
      <svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-12">
        <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="white"/>
      </svg>
    </div>
  </header>

  <!-- ░░░ FEATURES ░░░ -->
  <section  class="bg-white py-20 px-6 md:px-16 lg:px-24">
    <div class="max-w-6xl mx-auto">
      <p class="text-center text-gray-400 uppercase tracking-widest text-xs font-semibold mb-2">Kenapa CuciYuk?</p>
      <h2 class="text-center text-3xl font-black text-purple mb-12">Keunggulan Kami</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

        <!-- Card 1 -->
        <div class="card-hover bg-skyBg rounded-2xl p-6 flex flex-col items-center text-center shadow-sm border border-white">
          <div class="w-16 h-16 bg-orange/10 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <circle cx="12" cy="12" r="9" stroke-width="2"/>
              <path stroke-linecap="round" stroke-width="2" d="M12 7v5l3 3"/>
            </svg>
          </div>
          <p class="font-bold text-purple text-sm leading-tight">Efisiensi Waktu,<br/>Air, dan Listrik</p>
          <p class="text-gray-400 text-xs mt-2">Hemat energi & lebih produktif</p>
        </div>

        <!-- Card 2 -->
        <div class="card-hover bg-skyBg rounded-2xl p-6 flex flex-col items-center text-center shadow-sm border border-white">
          <div class="w-16 h-16 bg-orange/10 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
              <circle cx="12" cy="11" r="3" stroke-width="2"/>
            </svg>
          </div>
          <p class="font-bold text-purple text-sm leading-tight">Pelacakan<br/>Online</p>
          <p class="text-gray-400 text-xs mt-2">Pantau status cucianmu real-time</p>
        </div>

        <!-- Card 3 -->
        <div class="card-hover bg-skyBg rounded-2xl p-6 flex flex-col items-center text-center shadow-sm border border-white">
          <div class="w-16 h-16 bg-orange/10 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
          <p class="font-bold text-purple text-sm leading-tight">Harga<br/>Terjangkau</p>
          <p class="text-gray-400 text-xs mt-2">Mulai dari Rp 5.000 saja!</p>
        </div>

        <!-- Card 4 -->
        <div class="card-hover bg-skyBg rounded-2xl p-6 flex flex-col items-center text-center shadow-sm border border-white">
          <div class="w-16 h-16 bg-orange/10 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
          </div>
          <p class="font-bold text-purple text-sm leading-tight">Kualitas<br/>Terjamin</p>
          <p class="text-gray-400 text-xs mt-2">Bersih, harum, & rapi setiap saat</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ░░░ SERVICES ░░░ -->
  <section id="layanan"class="services-bg py-20 px-6 md:px-16 lg:px-24">
    <div class="max-w-6xl mx-auto">
      <p class="text-center text-white/70 uppercase tracking-widest text-xs font-semibold mb-2">Apa yang Kami Cuci?</p>
      <h2 class="text-center text-3xl md:text-4xl font-black text-white mb-12 drop-shadow">
        Layanan CuciYuk Laundry
      </h2>

      <div class="grid grid-cols-2 md:grid-cols-3 gap-5">

        <!-- Service 1: Laundry Kiloan -->
       <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-36 overflow-hidden">
              <img src="https://i.pinimg.com/736x/de/ce/55/dece553f16399e7ae1c593451c08fe10.jpg" alt="Laundry Kiloan" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"/>
          </div>
          <div class="p-4 flex flex-col flex-1">
              <p class="font-bold text-purple text-sm mb-1">Laundry Kiloan</p>
              <p class="text-gray-400 text-xs mb-3 flex-1">Cocok untuk cucian harian rumah tangga</p>
              
              @auth
                  <a href="{{ route('order.kiloan') }}" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 5.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </a>
              @else
                  <button @click="showLogin = true" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 5.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </button>
              @endauth
          </div>
      </div>
        <!-- Service 2: Laundry Permadani/Karpet -->
        <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-36 overflow-hidden">
            <img src="https://i.pinimg.com/1200x/c5/4b/9a/c54b9a59770d07b07c17474707fa3b36.jpg" alt="Laundry Permadani" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"/>
          </div>
          <div class="p-4 flex flex-col flex-1">
            <p class="font-bold text-purple text-sm mb-1">Laundry Permadani</p>
            <p class="text-gray-400 text-xs mb-3 flex-1">Karpet & permadani bersih sempurna</p>
              @auth
                  <a href="{{ route('order.permadani') }}" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 45.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </a>
              @else
                  <button @click="showLogin = true" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 45.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </button>
              @endauth
          </div>
        </div>

        <!-- Service 3: Setrika -->
        <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-36 overflow-hidden">
            <img src="https://i.pinimg.com/736x/a2/8d/98/a28d9833c76b3a7f667332bee6c520d4.jpg" alt="Setrika" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"/>
          </div>
          <div class="p-4 flex flex-col flex-1">
            <p class="font-bold text-purple text-sm mb-1">Setrika</p>
            <p class="text-gray-400 text-xs mb-3 flex-1">Pakaian rapi tanpa kerutan</p>
             
              @auth
                  <a href="{{ route('order.setrika') }}" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 5.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </a>
              @else
                  <button @click="showLogin = true" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 5.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </button>
              @endauth
          </div>
        </div>

        <!-- Service 4: Laundry Boneka -->
        <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-36 overflow-hidden">
            <img src="https://i.pinimg.com/1200x/b0/a7/7b/b0a77b575118658fd1f3757587c1120b.jpg" alt="Laundry Boneka" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"/>
          </div>
          <div class="p-4 flex flex-col flex-1">
            <p class="font-bold text-purple text-sm mb-1">Laundry Boneka</p>
            <p class="text-gray-400 text-xs mb-3 flex-1">Boneka kesayangan bersih & wangi</p>
             
              @auth
                  <a href="{{ route('order.boneka') }}" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 25.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </a>
              @else
                  <button @click="showLogin = true" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 25.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </button>
              @endauth
          </div>
        </div>

        <!-- Service 5: Laundry Gorden -->
        <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-36 overflow-hidden">
            <img src="https://i.pinimg.com/736x/86/cc/23/86cc2359a6bd217deea4c60d7c5b9ead.jpg" alt="Laundry Gorden" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"/>
          </div>
          <div class="p-4 flex flex-col flex-1">
            <p class="font-bold text-purple text-sm mb-1">Laundry Gorden</p>
            <p class="text-gray-400 text-xs mb-3 flex-1">Gorden bersih & bebas debu</p>
            
              @auth
                  <a href="{{ route('order.gorden') }}" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 35.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </a>
              @else
                  <button @click="showLogin = true" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 35.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </button>
              @endauth
          </div>
        </div>

        <!-- Service 6: Laundry Bedcover -->
        <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg flex flex-col">
          <div class="h-36 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400&q=80" alt="Laundry Bedcover" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"/>
          </div>
          <div class="p-4 flex flex-col flex-1">
            <p class="font-bold text-purple text-sm mb-1">Laundry Bedcover</p>
            <p class="text-gray-400 text-xs mb-3 flex-1">Sprei & bedcover harum bersih</p>
             
              @auth
                  <a href="{{ route('order.bedcover') }}" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 25.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </a>
              @else
                  <button @click="showLogin = true" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 25.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </button>
              @endauth
          </div>
        </div>

      </div>

      <!-- Laundry Sepatu – centered below grid -->
      <div class="mt-5 flex justify-center">
        <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg flex flex-col w-full max-w-xs">
          <div class="h-36 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80" alt="Laundry Sepatu" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500"/>
          </div>
          <div class="p-4 flex flex-col flex-1">
            <p class="font-bold text-purple text-sm mb-1">Laundry Sepatu</p>
            <p class="text-gray-400 text-xs mb-3 flex-1">Sepatu kinclong seperti baru lagi</p>
             
              @auth
                  <a href="{{ route('order.sepatu') }}" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 20.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </a>
              @else
                  <button @click="showLogin = true" class="w-full bg-orange text-white text-xs font-bold py-2.5 rounded-xl hover:bg-orangeHot hover:scale-105 transition-all duration-300 flex items-center justify-between px-3">
                      <span>Mulai dari Rp 20.000</span>
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                  </button>
              @endauth
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ░░░ TESTIMONIAL STRIP ░░░ -->
  <section class="bg-white py-16 px-6 md:px-16 lg:px-24">
    <div class="max-w-6xl mx-auto">
      <p class="text-center text-gray-400 uppercase tracking-widest text-xs font-semibold mb-2">Apa Kata Mereka?</p>
      <h2 class="text-center text-3xl font-black text-purple mb-10">Pelanggan Bahagia 🎉</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-skyBg rounded-2xl p-6 card-hover">
          <div class="flex gap-1 mb-3">
            <span class="text-orange">★★★★★</span>
          </div>
          <p class="text-gray-600 text-sm italic mb-4">"Cucian selalu bersih dan harum. Antar-jemput juga tepat waktu. Recommended banget!"</p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-purple text-white flex items-center justify-center font-bold text-sm">A</div>
            <div>
              <p class="font-bold text-purple text-sm">Andi Kusuma</p>
              <p class="text-gray-400 text-xs">Pelanggan Setia</p>
            </div>
          </div>
        </div>
        <div class="bg-skyBg rounded-2xl p-6 card-hover">
          <div class="flex gap-1 mb-3">
            <span class="text-orange">★★★★★</span>
          </div>
          <p class="text-gray-600 text-sm italic mb-4">"Harga terjangkau tapi kualitasnya bintang lima! Gorden saya jadi kaya baru lagi."</p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-orange text-white flex items-center justify-center font-bold text-sm">S</div>
            <div>
              <p class="font-bold text-purple text-sm">Sari Dewi</p>
              <p class="text-gray-400 text-xs">Pelanggan Baru</p>
            </div>
          </div>
        </div>
        <div class="bg-skyBg rounded-2xl p-6 card-hover">
          <div class="flex gap-1 mb-3">
            <span class="text-orange">★★★★★</span>
          </div>
          <p class="text-gray-600 text-sm italic mb-4">"Tracking online-nya keren! Bisa pantau cucian dari kantor. Super praktis!"</p>
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-blueMed text-white flex items-center justify-center font-bold text-sm">R</div>
            <div>
              <p class="font-bold text-purple text-sm">Rizky Pratama</p>
              <p class="text-gray-400 text-xs">Pelanggan VIP</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ░░░ NEWSLETTER FOOTER ░░░ -->
  <footer class="bg-blueMed relative overflow-hidden py-16 px-6 md:px-16 lg:px-24">
    <!-- Decorative circles -->
    <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full bg-white/10"></div>
    <div class="absolute -bottom-10 -left-10 w-40 h-40 rounded-full bg-white/10"></div>

    <div class="relative max-w-2xl mx-auto text-center">
      <p class="text-white/70 text-sm font-medium mb-2 uppercase tracking-widest">Jangan Ketinggalan</p>
      <h2 class="text-2xl md:text-3xl font-black text-white mb-2">
        Dapatkan Tawaran Special dari Kami
      </h2>
      <p class="text-4xl md:text-5xl font-black text-orange mb-8 leading-tight">
        Langganan Newsletter<br/>CuciYuk 🧺
      </p>
      <div class="flex flex-col sm:flex-row gap-3 max-w-lg mx-auto">
        <div class="flex-1 bg-white rounded-full px-5 py-3 flex items-center gap-3 shadow-inner">
          <svg class="w-5 h-5 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          <input type="email" placeholder="Masukan Email Kamu" class="flex-1 outline-none text-gray-600 text-sm bg-transparent placeholder-gray-400"/>
        </div>
        <button class="bg-orange text-white font-bold text-sm px-7 py-3 rounded-full shadow-lg hover:bg-orangeHot hover:scale-105 transition-all duration-300 hover:shadow-orange/40 hover:shadow-xl whitespace-nowrap">
          Berlangganan 🚀
        </button>
      </div>
      <p class="text-white/50 text-xs mt-4">Tidak ada spam. Bisa unsubscribe kapanpun.</p>
    </div>
    <div id="loginModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-[30px] shadow-2xl w-full max-w-md relative">
        <button onclick="closeModal('loginModal')" class="absolute top-5 right-5 text-gray-400 hover:text-gray-600">✕</button>
        
        <h2 class="text-2xl font-bold text-purple mb-6 text-center">Masuk ke CuciYuk</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" required class="w-full mt-1 border-gray-300 rounded-xl shadow-sm focus:border-blueMed focus:ring-blueMed">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full mt-1 border-gray-300 rounded-xl shadow-sm focus:border-blueMed focus:ring-blueMed">
            </div>
            <button type="submit" class="w-full bg-blueDark text-white py-3 rounded-xl font-bold hover:bg-blueMed transition">Masuk Sekarang</button>
        </form>
    </div>
</div>

<!-- Kontak -->
 <section id="kontak" class="py-20 bg-brandbg">
    <div class="max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Layanan Pelanggan</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Ada kendala dengan cucian atau mau tanya soal jemput antar? Tim CuciYuk siap bantu!
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
            
            <div class="p-8 md:p-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h2>
                 <form id="contact-form" class="space-y-6" onsubmit="submitForm(event)">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brandblue focus:border-brandblue outline-none transition duration-200 placeholder-gray-400"
                            placeholder="Masukkan nama lengkap Anda">
                    </div>

                    <!-- Nomor Telepon & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="telepon" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="tel" id="telepon" name="telepon" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brandblue focus:border-brandblue outline-none transition duration-200 placeholder-gray-400"
                                placeholder="Contoh: 081234567890">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brandblue focus:border-brandblue outline-none transition duration-200 placeholder-gray-400"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <!-- Pertanyaan -->
                    <div>
                        <label for="pertanyaan" class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan / Pesan</label>
                        <textarea id="pertanyaan" name="pertanyaan" rows="5" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-brandblue focus:border-brandblue outline-none transition duration-200 placeholder-gray-400 resize-none"
                            placeholder="Tuliskan detail pertanyaan atau keluhan Anda di sini..."></textarea>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                        class="w-full bg-brandblue hover:bg-brandhover text-black font-semibold py-3 px-6 rounded-xl transition duration-300 shadow-md hover:shadow-lg flex justify-center items-center">
                        <span>Kirim Pesan</span>
                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                  </form>
            </div>

            <div class="bg-gray-50 p-8 md:p-12 border-l border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Toko</h2>
                    <p class="text-gray-600 mb-8">
                        Kunjungi toko fisik kami atau hubungi kami secara langsung melalui kontak di bawah ini.
                    </p>

                    <div class="space-y-6">
                        <!-- Alamat -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="p-3 bg-blue-100 text-brandblue rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Alamat Toko</h3>
                                <p class="text-gray-600 mt-1">Jl. Mawar Indah No. 45<br>Kec. Serpong, Tangerang<br>Banten, Indonesia 15310</p>
                            </div>
                        </div>

                        <!-- Telepon -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="p-3 bg-blue-100 text-brandblue rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">No. Handphone</h3>
                                <p class="text-gray-600 mt-1">+62 812-3456-7890</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="p-3 bg-blue-100 text-brandblue rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Email</h3>
                                <p class="text-gray-600 mt-1">support@tokoanda.com</p>
                            </div>
                        </div>
                <!-- Jam Operasional -->
                <div class="mt-10 pt-8 border-t border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-brandblue mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jam Operasional Toko
                    </h3>
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-3 pb-3 border-b border-gray-100">
                            <span class="font-medium text-gray-700">Senin - Jumat (Weekday)</span>
                            <span class="text-brandblue font-semibold">09:00 - 20:00</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">Sabtu - Minggu (Weekend)</span>
                            <span class="text-brandblue font-semibold">10:00 - 18:00</span>
                        </div>
                    </div>
                </div>
              </div>
            </div>
            </div>
        </div>
    </div>
</section>



    <!-- Bottom bar -->
    <div class="relative mt-14 pt-6 border-t border-white/20 flex flex-col md:flex-row items-center justify-between gap-4 max-w-6xl mx-auto">
      <p class="text-white/60 text-sm">© 2025 CuciYuk Laundry. All rights reserved.</p>
      <div class="flex gap-6 text-white/60 text-sm">
        <a href="#" class="hover:text-white transition-colors">Tentang Kami</a>
        <a href="#" class="hover:text-white transition-colors">Kontak</a>
        <a href="#" class="hover:text-white transition-colors">Privacy</a>
      </div>
    </div>
  </footer>
 @include('auth.login-modal')
 @include('partials.scripts')
</body>
</html>
<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
    function submitForm(event) {
        event.preventDefault(); 
        const form = document.getElementById('contact-form');
        const successMessage = document.getElementById('success-message');
        
        successMessage.classList.remove('hidden');
        form.reset();
        
        setTimeout(() => {
            successMessage.classList.add('hidden');
        }, 5000); 
    }

    const tombolDropdown = document.getElementById('tombol-dropdown');
    const isiDropdown = document.getElementById('isi-dropdown');

    // Ketika tombol diklik, tambah/hapus class 'hidden' pada isi dropdown
    tombolDropdown.addEventListener('click', function(event) {
      isiDropdown.classList.toggle('hidden');
      // Mencegah klik tombol menutup dropdown seketika (event bubbling)
      event.stopPropagation(); 
    });

    // Jika user klik di luar dropdown, menu otomatis tertutup
    document.addEventListener('click', function(event) {
      if (!tombolDropdown.contains(event.target) && !isiDropdown.contains(event.target)) {
        isiDropdown.classList.add('hidden');
      }
    });
</script>