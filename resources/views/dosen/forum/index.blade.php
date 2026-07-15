@extends('layouts.dashboard')

@section('title', 'Forum Diskusi (Dosen) - ' . $course->nama_makul)

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('dosen.courses.show', $course->id) }}" class="text-slate-400 hover:text-cyan-600 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola Forum Diskusi</h1>
    </div>
    <p class="text-slate-500 dark:text-slate-400 ml-8">{{ $course->nama_makul }}</p>
</div>

<div class="space-y-4">
    @forelse($discussions as $discussion)
    <div class="block bg-white dark:bg-slate-800 rounded-2xl p-6 border {{ $discussion->is_pinned ? 'border-amber-300 dark:border-amber-500/50 shadow-md shadow-amber-100 dark:shadow-none' : 'border-slate-200 dark:border-slate-700' }} transition relative">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
                <a href="{{ route('dosen.courses.forum.show', [$course->id, $discussion->id]) }}" class="hover:text-cyan-600">
                    <div class="flex items-center gap-3 mb-2">
                        @if($discussion->is_pinned)
                            <span class="bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-xs px-2 py-1 rounded-md font-bold flex items-center gap-1">
                                <i class="fas fa-thumbtack"></i> Pinned
                            </span>
                        @endif
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white hover:text-cyan-600 transition">{{ $discussion->title }}</h3>
                    </div>
                </a>
                <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-2 mb-4">{{ $discussion->body }}</p>
                <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-500">
                    <span class="flex items-center gap-1">
                        <i class="fas fa-user-circle"></i> {{ $discussion->user->name }}
                        @if($discussion->user->role === 'dosen')
                            <span class="bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 px-1.5 py-0.5 rounded text-[10px] ml-1">Dosen</span>
                        @endif
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="far fa-clock"></i> {{ $discussion->created_at->diffForHumans() }}
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="far fa-comment"></i> {{ $discussion->replies->count() }} Balasan
                    </span>
                </div>
            </div>
            
            <div class="flex flex-col gap-2 shrink-0">
                <form action="{{ route('dosen.courses.forum.pin', [$course->id, $discussion->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/30 transition" title="{{ $discussion->is_pinned ? 'Unpin' : 'Pin' }}">
                        <i class="fas fa-thumbtack {{ $discussion->is_pinned ? 'text-amber-500' : '' }}"></i>
                    </button>
                </form>
                <form action="{{ route('dosen.courses.forum.destroy', [$course->id, $discussion->id]) }}" method="POST" onsubmit="return confirm('Hapus diskusi ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 transition" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center py-12 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700">
        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-comments text-slate-400 text-2xl"></i>
        </div>
        <p class="text-slate-500 dark:text-slate-400">Belum ada diskusi di forum ini.</p>
    </div>
    @endforelse

    <div class="mt-6">
        {{ $discussions->links() }}
    </div>
</div>
@endsection
