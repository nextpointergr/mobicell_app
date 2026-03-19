@can('admin.products')
<li class="list-none group">
    @php $isActive = request()->routeIs('admin.products'); @endphp
    <a href="{{ route('admin.products') }}"
       class="flex items-center gap-4 px-4 py-2.5 rounded-xl transition-all duration-300 relative
       {{ $isActive ? 'text-slate-900 bg-slate-50/50' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900 hover:translate-x-1' }}">

        <i class="ti ti-smart-home text-[20px] transition-colors
        {{ $isActive ? 'text-[#c02228]' : 'text-slate-300 group-hover:text-slate-500' }}"></i>

        <span class="font-bold text-[13.5px] tracking-tight">{{ __('Products') }}</span>

        @if($isActive)
            <div class="absolute -left-4 w-1 h-5 bg-[#c02228] rounded-r-full shadow-[2px_0_10px_rgba(192,34,40,0.2)]"></div>
        @endif
    </a>
</li>
@endcan
