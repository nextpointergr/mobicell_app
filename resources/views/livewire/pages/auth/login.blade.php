<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>
<div class="animate-in fade-in slide-in-from-bottom-6 duration-700">
    <div class="mb-12 text-center lg:text-left">
        <h3 class="text-4xl lg:text-5xl font-[900] text-slate-900 tracking-tighter leading-none uppercase">{{ __('ΣΥΝΔΕΣΗ') }}</h3>
        <div class="h-1.5 w-12 bg-[#d5112a] mt-4 mb-4 mx-auto lg:mx-0"></div>
        <p class="text-slate-400 text-[11px] font-bold uppercase tracking-[0.1em]">Authorized retailers only</p>
    </div>

    <form wire:submit="login" class="space-y-8">
        <div class="space-y-2 group">
            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 ml-2 group-focus-within:text-[#d5112a] transition-colors">Account ID</label>
            <input wire:model="form.email" id="email" type="email" required autofocus
                   class="w-full bg-slate-50 border-2 border-slate-100 px-6 py-4 rounded-2xl text-sm text-slate-800 focus:bg-white focus:border-[#d5112a] transition-all duration-300 outline-none font-bold"
                   placeholder="e.g. store@mobicell.gr" />
            <x-input-error :messages="$errors->get('form.email')" class="text-[10px] font-bold text-red-500 uppercase tracking-tight ml-2" />
        </div>

        <div class="space-y-2 group">
            <div class="flex justify-between items-center px-2">
                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400 group-focus-within:text-[#d5112a] transition-colors">Security Key</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-bold text-[#d5112a] hover:text-red-700 transition-colors uppercase tracking-tighter" href="{{ route('password.request') }}" wire:navigate>Recovery</a>
                @endif
            </div>
            <input wire:model="form.password" id="password" type="password" required
                   class="w-full bg-slate-50 border-2 border-slate-100 px-6 py-4 rounded-2xl text-sm text-slate-800 focus:bg-white focus:border-[#d5112a] transition-all duration-300 outline-none font-bold"
                   placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="text-[10px] font-bold text-red-500 uppercase tracking-tight ml-2" />
        </div>

        <div class="flex items-center px-2">
            <label class="flex items-center cursor-pointer group">
                <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-[#d5112a] focus:ring-0 transition-all cursor-pointer">
                <span class="ml-3 text-[11px] font-bold text-slate-500 group-hover:text-slate-900 transition-colors uppercase tracking-tight">Stay logged in</span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.3em] shadow-xl hover:bg-[#d5112a] active:scale-[0.98] transition-all duration-500 group relative overflow-hidden">
                <span class="relative z-10 flex items-center justify-center gap-2">
                    Establish Connection
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </span>
                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </button>
        </div>
    </form>
</div>



