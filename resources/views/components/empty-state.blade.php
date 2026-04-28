@props([
    'icon' => 'fas fa-inbox',
    'title' => 'Data Tidak Ditemukan',
    'description' => 'Belum ada data untuk ditampilkan saat ini.',
    'actionText' => null,
    'actionUrl' => null,
    'actionOnClick' => null,
])

<div {{ $attributes->merge(['class' => 'py-16 px-6 empty-state-card rounded-[2.5rem] text-center max-w-2xl mx-auto']) }}>
    <div class="w-20 h-20 empty-state-icon rounded-3xl flex items-center justify-center mx-auto mb-6">
        <i class="{{ $icon }} text-3xl text-slate-300"></i>
    </div>
    <h3 class="text-2xl font-bold text-slate-800 mb-2">{{ $title }}</h3>
    <p class="text-slate-500 mb-8">{{ $description }}</p>
    
    @if($actionText && ($actionUrl || $actionOnClick))
        @if($actionUrl)
            <a href="{{ $actionUrl }}" class="inline-flex items-center gap-2 px-8 py-4 bg-cyan-600 text-white rounded-2xl font-bold hover:bg-cyan-700 transition shadow-xl shadow-cyan-500/20">
                {{ $actionText }}
            </a>
        @else
            <button onclick="{{ $actionOnClick }}" class="inline-flex items-center gap-2 px-8 py-4 bg-cyan-600 text-white rounded-2xl font-bold hover:bg-cyan-700 transition shadow-xl shadow-cyan-500/20">
                {{ $actionText }}
            </button>
        @endif
    @endif
</div>
