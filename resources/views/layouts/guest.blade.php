<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Mobicell') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-['Roboto'] antialiased bg-[#f8f9fa] text-slate-900 overflow-x-hidden">

<div class="fixed inset-0 z-0 overflow-hidden pointer-events-none hidden sm:block">
    <div class="absolute top-0 right-0 w-[40%] h-[40%] bg-[#d5112a]/5 blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-[40%] h-[40%] bg-[#868d90]/10 blur-[120px]"></div>

    <div class="absolute inset-0 flex items-center justify-center">
        <h1 class="text-[28vw] font-[900] leading-none tracking-tighter opacity-[0.03] text-[#868d90] uppercase">
            Mobicell
        </h1>
    </div>
</div>

<div class="min-h-screen relative z-10 flex flex-col lg:flex-row w-full">

    <div class="w-full lg:w-3/5 flex flex-col justify-between p-8 lg:p-24 order-2 lg:order-1 text-center lg:text-left">
        <div class="flex items-center justify-center lg:justify-start gap-4 mb-16">
            <img src="{{ asset('images/logo.png') }}" alt="Mobicell" class="h-10 w-auto">
            <div class="h-8 w-[2px] bg-slate-200"></div>
            <div class="flex flex-col text-left">
                <span class="text-[10px] font-bold uppercase tracking-[0.4em] text-slate-400 leading-none">Retail Portal</span>
                <span class="text-[8px] font-black text-[#d5112a] uppercase mt-1 tracking-widest">Network Secure</span>
            </div>
        </div>

        <div class="max-w-2xl mx-auto lg:mx-0 mb-16 lg:mb-0">
            <h2 class="text-5xl sm:text-7xl lg:text-[110px] font-[900] tracking-tighter text-slate-900 leading-[0.85] mb-8 uppercase">
                Stay<br/>
                <span class="relative inline-block text-[#d5112a]">
                    Connected
                </span>
            </h2>
            <div class="flex items-center justify-center lg:justify-start gap-4 mb-8">
                <div class="h-[4px] w-16 bg-[#d5112a]"></div>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-[0.3em]">{{ __('Official Store Management') }}</p>
            </div>
            <p class="text-lg lg:text-2xl text-slate-400 font-light leading-snug max-w-lg">
                {{ __('Access your store and manage everything.') }}
            </p>
        </div>

        <div class="flex flex-col items-center lg:items-start gap-2">
            <span class="text-[9px] uppercase tracking-[0.5em] text-slate-300 font-bold">
                {{ __('Platform Development & Architecture') }}
            </span>
            <a href="https://nextpointer.gr" target="_blank" class="text-base font-black hover:text-[#d5112a] transition-all tracking-tight">
                nextpointer.gr
            </a>
        </div>
    </div>

    <div class="w-full lg:w-2/5 flex items-center justify-center p-6 lg:p-12 order-1 lg:order-2 bg-white lg:bg-transparent">
        <div class="w-full max-w-[440px] relative">
            <div class="bg-white lg:shadow-[0_40px_100px_-20px_rgba(0,0,0,0.1)] rounded-[48px] p-10 lg:p-16 border border-slate-50 lg:border-white">
                {{ $slot }}
            </div>
        </div>
    </div>

</div>
</body>
</html>
