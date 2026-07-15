@extends('layouts.dashboard')

@section('title', $discussion->title)

@section('content')
<div class="mb-6">
    <a href="{{ route('dosen.courses.forum.index', $course->id) }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-cyan-600 transition mb-4">
        <i class="fas fa-arrow-left"></i> Kembali ke Forum
    </a>
</div>

{{-- Main Discussion --}}
<div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border {{ $discussion->is_pinned ? 'border-amber-300 dark:border-amber-500/50 shadow-md shadow-amber-100 dark:shadow-none' : 'border-slate-200 dark:border-slate-700' }} p-6 mb-8 relative overflow-hidden">
    @if($discussion->is_pinned)
        <div class="absolute top-0 right-0 bg-amber-400 text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg">
            <i class="fas fa-thumbtack"></i> PINNED
        </div>
    @endif
    
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center shrink-0">
            <span class="text-xl font-bold text-slate-600 dark:text-slate-300">{{ strtoupper(substr($discussion->user->name, 0, 1)) }}</span>
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <h1 class="text-xl font-bold text-slate-800 dark:text-white mb-1">{{ $discussion->title }}</h1>
                <div class="flex gap-2">
                    <form action="{{ route('dosen.courses.forum.pin', [$course->id, $discussion->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-slate-400 hover:text-amber-500 transition" title="Toggle Pin">
                            <i class="fas fa-thumbtack {{ $discussion->is_pinned ? 'text-amber-500' : '' }}"></i>
                        </button>
                    </form>
                    <form action="{{ route('dosen.courses.forum.destroy', [$course->id, $discussion->id]) }}" method="POST" onsubmit="return confirm('Hapus diskusi ini?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm text-slate-400 hover:text-red-500 transition" title="Hapus Diskusi">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-4">
                <span>{{ $discussion->user->name }}</span>
                @if($discussion->user->role === 'dosen')
                    <span class="bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 px-1.5 py-0.5 rounded text-[10px]">Dosen</span>
                @endif
                <span>&bull;</span>
                <span>{{ $discussion->created_at->format('d M Y H:i') }}</span>
            </div>
            <div class="prose dark:prose-invert max-w-none text-slate-700 dark:text-slate-300 whitespace-pre-wrap">
                {{ $discussion->body }}
            </div>
        </div>
    </div>
</div>

{{-- Replies Section --}}
<div class="mb-8 flex items-center justify-between">
    <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ $discussion->replies->count() }} Balasan</h3>
</div>

<div class="space-y-6">
    @foreach($discussion->topLevelReplies as $reply)
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6" id="reply-{{ $reply->id }}">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center shrink-0">
                    <span class="text-lg font-bold text-slate-600 dark:text-slate-300">{{ strtoupper(substr($reply->user->name, 0, 1)) }}</span>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                            <span class="font-bold text-slate-700 dark:text-slate-300">{{ $reply->user->name }}</span>
                            @if($reply->user->role === 'dosen')
                                <span class="bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 px-1.5 py-0.5 rounded text-[10px]">Dosen</span>
                            @endif
                            <span>&bull;</span>
                            <span>{{ $reply->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <div class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap mb-3 text-sm">{{ $reply->body }}</div>
                    
                    <button onclick="document.getElementById('reply-form-{{ $reply->id }}').classList.toggle('hidden')" class="text-xs text-cyan-600 hover:text-cyan-700 dark:text-cyan-400 font-semibold mb-4 focus:outline-none">
                        Balas
                    </button>

                    {{-- Reply to Reply Form --}}
                    <div id="reply-form-{{ $reply->id }}" class="hidden mb-4">
                        <form action="{{ route('dosen.courses.forum.reply', [$course->id, $discussion->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" value="{{ $reply->id }}">
                            <textarea name="body" required rows="2" placeholder="Tulis balasan..." class="w-full px-4 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:text-white resize-none mb-2"></textarea>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="document.getElementById('reply-form-{{ $reply->id }}').classList.add('hidden')" class="px-3 py-1.5 text-xs text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg transition">Batal</button>
                                <button type="submit" class="px-3 py-1.5 text-xs bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition">Kirim</button>
                            </div>
                        </form>
                    </div>

                    {{-- Nested Replies --}}
                    @if($reply->children->count() > 0)
                        <div class="space-y-4 mt-4 border-l-2 border-slate-100 dark:border-slate-700 pl-4">
                            @foreach($reply->children as $child)
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center shrink-0">
                                        <span class="text-sm font-bold text-slate-600 dark:text-slate-300">{{ strtoupper(substr($child->user->name, 0, 1)) }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-1">
                                            <span class="font-bold text-slate-700 dark:text-slate-300">{{ $child->user->name }}</span>
                                            @if($child->user->role === 'dosen')
                                                <span class="bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400 px-1.5 py-0.5 rounded text-[10px]">Dosen</span>
                                            @endif
                                            <span>&bull;</span>
                                            <span>{{ $child->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap text-sm">{{ $child->body }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Write Reply --}}
<div class="mt-8 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
    <h4 class="font-bold text-slate-800 dark:text-white mb-4">Tulis Balasan Dosen</h4>
    <form action="{{ route('dosen.courses.forum.reply', [$course->id, $discussion->id]) }}" method="POST">
        @csrf
        <textarea name="body" required rows="4" placeholder="Berikan tanggapan atau penjelasan..." class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 dark:text-white resize-none mb-3"></textarea>
        <div class="flex justify-end">
            <button type="submit" class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-2 rounded-xl font-medium transition">
                Kirim Balasan
            </button>
        </div>
    </form>
</div>
@endsection
