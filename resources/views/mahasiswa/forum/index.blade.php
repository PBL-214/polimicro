@extends('layouts.dashboard')

@section('title', 'Forum Diskusi - ' . $course->nama_makul)

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4 mb-2">
        <a href="{{ route('mahasiswa.courses.show', $course->id) }}" class="text-slate-400 hover:text-cyan-600 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Forum Diskusi</h1>
    </div>
    <p class="text-slate-500 dark:text-slate-400 ml-8">{{ $course->nama_makul }}</p>
</div>

<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 mb-8">
    <form action="{{ route('mahasiswa.courses.forum.store', $course->id) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Mulai Diskusi Baru</label>
            <input type="text" name="title" required placeholder="Judul diskusi..." class="w-full px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:text-white mb-3">
            <textarea name="body" required rows="3" placeholder="Tulis sesuatu..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:text-white resize-none"></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-xl font-medium transition flex items-center gap-2">
                <i class="fas fa-paper-plane"></i> Kirim
            </button>
        </div>
    </form>
</div>

<div class="space-y-4">
    @forelse($discussions as $discussion)
    <a href="{{ route('mahasiswa.courses.forum.show', [$course->id, $discussion->id]) }}" class="block bg-white dark:bg-slate-800 rounded-2xl p-6 border {{ $discussion->is_pinned ? 'border-amber-300 dark:border-amber-500/50 shadow-md shadow-amber-100 dark:shadow-none' : 'border-slate-200 dark:border-slate-700 hover:border-cyan-300 dark:hover:border-cyan-600' }} transition">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    @if($discussion->is_pinned)
                        <span class="bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 text-xs px-2 py-1 rounded-md font-bold flex items-center gap-1">
                            <i class="fas fa-thumbtack"></i> Pinned
                        </span>
                    @endif
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ $discussion->title }}</h3>
                </div>
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
            <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center shrink-0">
                <i class="fas fa-chevron-right text-slate-400"></i>
            </div>
        </div>
    </a>
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
