<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Perfetto') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-[Inter] h-screen overflow-hidden">

<div class="h-screen grid grid-cols-1 lg:grid-cols-2">
    <div class="hidden lg:flex flex-col justify-between p-20 relative overflow-hidden bg-[#0d0f11]">

        <div class="absolute inset-0 z-0 opactiy-10">
            <div class="absolute inset-0 bg-[linear-gradient(rgba(213,17,42,0.1)_1px,transparent_1px),linear-gradient(90deg,rgba(213,17,42,0.1)_1px,transparent_1px)] [background-size:60px_60px]"></div>

            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-[800px] h-[800px] rounded-full bg-gradient-to-r from-[#d5112a]/5 to-[#ff4d6d]/5 blur-[200px] animate-pulse-glow"></div>
            </div>

            <div class="js-mouse-glow absolute w-64 h-64 bg-[#ff4d6d]/10 rounded-full blur-[100px] pointer-events-none transition-transform duration-100 ease-out opacity-0"></div>
        </div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full bg-black/30 border border-white/5 backdrop-blur-md shadow-inner">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500 shadow-lg shadow-green-500/50"></span>
            </span>
                <span class="text-xs font-semibold text-white/70 tracking-widest uppercase">{{ __('CORE OPERATIONAL // v2.0') }}</span>
            </div>
        </div>

        <div class="relative z-10 max-w-xl">
            <h1 class="text-[120px] font-black tracking-[-0.05em] mb-4 leading-none">
                <span class="text-white">Mobicell</span><span class="bg-clip-text text-transparent bg-gradient-to-b from-[#d5112a] to-[#ff4d6d] drop-shadow-lg">.</span>
            </h1>

            <div class="h-[1px] w-full max-w-sm mb-10 bg-white/10 relative overflow-hidden rounded-full">
                <div class="absolute top-0 left-0 h-full w-24 bg-gradient-to-r from-transparent via-[#d5112a] to-transparent animate-flow-line"></div>
            </div>

            <p class="text-3xl text-white/90 font-light leading-snug tracking-wide max-w-md">
                {{ __('The central ecosystem, unifying operations with absolute control and intelligence.') }}
            </p>
        </div>

        <div class="relative z-10 flex items-end justify-between border-t border-white/5 pt-10">
            <div class="flex flex-col border-l border-[#d5112a] pl-5">
                <span class="text-white/30 uppercase tracking-[0.3em] text-[10px] mb-1.5">{{ __('Platform Development & Architecture') }}</span>
                <a href="https://nextpointer.gr" target="_blank" class="text-white/70 hover:text-white transition-all flex items-center gap-2 font-medium group">
                    nextpointer<span class="text-[#d5112a]">.</span>gr
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
            <div class="text-white/50 text-[10px] uppercase tracking-[0.3em] select-none font-mono">
               IP:{{ request()->ip() }}
            </div>
        </div>
    </div>

    <div class="flex items-center justify-center bg-white px-6">
        <div class="w-full max-w-sm">
            <div class="flex justify-center mb-12">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="mobicell.gr"
                    class="h-20 w-auto">
            </div><!-- flex justify-center mb-12 -->
            {{ $slot }}
            <p class="text-center text-xs text-slate-400 mt-12">
                {{ __('©') }} {{ date('Y') }} {{ __('Mobicell. All rights reserved.') }}
            </p><!-- text-center text-xs text-slate-400 mt-12 -->
        </div><!-- w-full max-w-sm -->
    </div><!-- flex items-center justify-center bg-white px-6 -->

</div>
<style>

    /* Animations */
    @keyframes pulse-glow {
        0%, 100% { transform: scale(1); opacity: 0.1; }
        50% { transform: scale(1.1); opacity: 0.2; }
    }
    .animate-pulse-glow {
        animation: pulse-glow 10s ease-in-out infinite;
    }

    @keyframes flow-line {
        0% { left: -100px; }
        100% { left: 100%; }
    }
    .animate-flow-line {
        animation: flow-line 3s ease-in-out infinite;
    }
</style>
</body>
</html>
