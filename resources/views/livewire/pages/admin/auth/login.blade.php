<?php

use App\Livewire\Forms\AdminLoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest-admin')] class extends Component
{
    public AdminLoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();
        $admin = auth('admin')->user();

        $admin->update([
            'last_login_at'    => now(),
            'last_login_ip'    => request()->ip(),
            'last_login_agent' => substr(request()->userAgent(), 0, 255),
        ]);

        Session::regenerate();
        $this->redirectRoute('admin.dashboard', navigate: false);

    }
}; ?>

<div>
    <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="text-center lg:text-left mb-10">
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">
                {{ __('Welcome to the system') }} <span class="text-[#d5112a]">.</span>
            </h2>
            <p class="text-slate-500 mt-2 font-light tracking-wide">
                {{ __('Please log in to manage the system.') }}
            </p>
        </div>

        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

        <form wire:submit="login" class="space-y-5">

            <div class="group relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400
                 group-focus-within:text-[#d5112a] transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                    </svg>
                </div>
                <input
                    wire:model="form.email"
                    id="email"
                    type="email"
                    required
                    placeholder=" "
                    class="peer w-full rounded-2xl border-slate-200 bg-slate-50/50 pl-11 pr-4 pt-6 pb-2
                   focus:border-[#d5112a] focus:ring-4 focus:ring-[#7fb239]/10 focus:bg-white
                   transition-all duration-300 outline-none placeholder-transparent"
                />



                <label
                    for="email"
                    class="absolute left-11 top-4 text-slate-400 text-sm font-medium
                   transition-all duration-300 pointer-events-none
                   peer-placeholder-shown:text-base peer-placeholder-shown:top-4
                   peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-[#d5112a]
                   peer-[:not(:placeholder-shown)]:top-1.5 peer-[:not(:placeholder-shown)]:text-xs"
                >
                    {{ __('Email') }}
                </label>
                <x-input-error :messages="$errors->get('form.email')" class="mt-1 text-xs font-semibold text-red-500 ml-2" />
            </div>

            <div class="group relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400
                 group-focus-within:text-[#d5112a] transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <input
                    wire:model="form.password"
                    id="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder=" "
                    class="peer w-full rounded-2xl border-slate-200 bg-slate-50/50 pl-11 pr-4 pt-6 pb-2
                   focus:border-[#d5112a] focus:ring-4 focus:ring-[#d5112a]/10 focus:bg-white
                   transition-all duration-300 outline-none placeholder-transparent"
                />
                <label
                    for="password"
                    class="absolute left-11 top-4 text-slate-400 text-sm font-medium
                   transition-all duration-300 pointer-events-none
                   peer-placeholder-shown:text-base peer-placeholder-shown:top-4
                   peer-focus:top-1.5 peer-focus:text-xs peer-focus:text-[#d5112a]
                   peer-[:not(:placeholder-shown)]:top-1.5 peer-[:not(:placeholder-shown)]:text-xs"
                >
                    {{ __('Password') }}
                </label>
                <x-input-error :messages="$errors->get('form.password')" class="mt-1 text-xs font-semibold text-red-500 ml-2" />
            </div>



            <div class="pt-2">
                <button
                    type="submit"
                    class="group relative w-full overflow-hidden rounded-2xl bg-[#d5112a] py-4 text-white font-bold
   shadow-[0_10px_20px_-10px_rgba(213,17,42,0.5)] hover:shadow-[0_15px_30px_-10px_rgba(213,17,42,0.6)]
   hover:bg-[#bc0f25] active:scale-[0.98] transition-all duration-200"
                >
                    <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>

                    <span class="relative z-10 flex items-center justify-center gap-2">
        {{ __('Log in to the System') }}
        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
        </svg>
    </span>
                </button>
            </div>
        </form>
    </div>

    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    </style>
</div>
