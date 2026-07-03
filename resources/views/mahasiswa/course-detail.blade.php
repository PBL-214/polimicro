@extends('layouts.dashboard', ['activePage' => 'courses'])
@section('title', $course->nama_makul . ' - Polimicro')
@section('content')
<div class="max-w-7xl mx-auto">
    <a href="{{ route('mahasiswa.courses') }}" class="mb-6 inline-flex items-center text-xs font-bold text-slate-500 hover:text-slate-800 transition"><i class="fas fa-arrow-left mr-2"></i>Kembali ke Mata Kuliah Saya</a>
    
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Navigation Tree Sidebar --}}
        <div class="lg:w-1/4 flex-shrink-0 order-2 lg:order-1">
            <div class="sticky top-28 bg-white rounded-3xl border border-gray-100 p-6 shadow-sm max-h-[calc(100vh-8rem)] overflow-y-auto custom-scrollbar">
                <h3 class="font-bold text-gray-900 mb-4 font-serif flex items-center gap-2"><i class="fas fa-stream text-cyan-600"></i> Navigasi Materi</h3>
                <ul class="space-y-3 text-sm">
                    @forelse($materials as $index => $mat)
                        <li>
                            <a href="#materi-{{ $mat->id }}" class="flex flex-col p-2 hover:bg-cyan-50 rounded-xl transition group">
                                <span class="font-semibold text-slate-700 group-hover:text-cyan-700 transition">Pertemuan {{ $index + 1 }}</span>
                                <span class="text-[10px] text-slate-500 group-hover:text-cyan-600 truncate">{{ $mat->nama_materi }}</span>
                            </a>
                            @php $connectedAssignments = $assignments->where('materi_id', $mat->id); @endphp
                            @if($connectedAssignments->count() > 0)
                                <ul class="ml-4 mt-1 space-y-1 border-l-2 border-slate-100 pl-3">
                                    @foreach($connectedAssignments as $t)
                                        <li>
                                            <a href="#tugas-{{ $t->id }}" class="flex items-center gap-2 py-1.5 text-xs text-slate-500 hover:text-cyan-600 transition group/tugas">
                                                <i class="fas fa-tasks text-[10px] text-cyan-400 group-hover/tugas:text-cyan-600"></i> 
                                                <span class="truncate">{{ $t->nama_tugas }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @empty
                        <li class="text-xs text-slate-400 italic">Belum ada materi</li>
                    @endforelse
                    
                    @php $unconnectedAssignments = $assignments->whereNull('materi_id'); @endphp
                    @if($unconnectedAssignments->count() > 0)
                        <li class="pt-3 mt-3 border-t border-slate-100">
                            <a href="#tugas-lainnya" class="font-semibold text-slate-700 hover:text-cyan-700 transition p-2 block rounded-xl hover:bg-cyan-50">Tugas Lainnya</a>
                            <ul class="ml-4 mt-1 space-y-1 border-l-2 border-slate-100 pl-3">
                                @foreach($unconnectedAssignments as $t)
                                    <li>
                                        <a href="#tugas-{{ $t->id }}" class="flex items-center gap-2 py-1.5 text-xs text-slate-500 hover:text-cyan-600 transition group/tugas">
                                            <i class="fas fa-tasks text-[10px] text-amber-400 group-hover/tugas:text-amber-600"></i> 
                                            <span class="truncate">{{ $t->nama_tugas }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="lg:w-3/4 order-1 lg:order-2">
            {{-- Course Header --}}
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2rem] p-8 text-white mb-8 shadow-xl shadow-slate-950/10 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl"><i class="fas fa-book-open"></i></div>
        <span class="text-xs font-bold uppercase tracking-widest text-cyan-400 mb-2 block">{{ $course->prodi->nama_prodi ?? '' }}</span>
        <h1 class="text-3xl font-extrabold mb-3 tracking-tight font-serif">{{ $course->nama_makul }}</h1>
        <p class="text-slate-300 text-sm max-w-2xl leading-relaxed mb-6">{{ $course->deskripsi ?: 'Kuasai kompetensi mendalam melalui kurikulum terstruktur dan bimbingan ahli.' }}</p>
        
        <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-white/10 text-xs">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center font-bold text-cyan-300 border border-white/5 shadow-sm">{{ $course->dosen ? $course->dosen->getInitials() : '?' }}</div>
                <div>
                    <p class="font-bold text-white">{{ $course->dosen->name ?? '-' }}</p>
                    <p class="text-slate-400 text-[10px]">Dosen Pengampu</p>
                </div>
            </div>
            <div class="h-8 w-px bg-white/10 hidden sm:block"></div>
            <div>
                <p class="font-bold text-cyan-300">{{ $course->sks }} SKS</p>
                <p class="text-slate-400 text-[10px]">Bobot SKS</p>
            </div>
            <div class="h-8 w-px bg-white/10 hidden sm:block"></div>
            <div>
                <p class="font-bold text-white">{{ $materials->count() }} Materi</p>
                <p class="text-slate-400 text-[10px]">Total File/Video</p>
            </div>
            <div class="h-8 w-px bg-white/10 hidden sm:block"></div>
            <div>
                <p class="font-bold text-white">{{ $assignments->count() }} Tugas</p>
                <p class="text-slate-400 text-[10px]">Total Kegiatan</p>
            </div>
        </div>
    </div>

    {{-- Course Contents --}}
    <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif flex items-center gap-2"><i class="fas fa-list-ul text-cyan-600"></i> Materi & Kegiatan Pembelajaran</h2>
    
    <div class="space-y-6">
        @forelse($materials as $index => $mat)
            <div id="materi-{{ $mat->id }}" class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300 overflow-hidden scroll-mt-28">
                {{-- Material Card Header --}}
                <div class="p-6 border-b border-gray-50 bg-slate-50/50 flex items-start justify-between gap-4">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600 border border-cyan-100 flex-shrink-0">
                            @if($mat->youtube_link)
                                <i class="fab fa-youtube text-xl"></i>
                            @else
                                <i class="fas fa-file-alt text-lg"></i>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-base">Pertemuan {{ $index + 1 }}: {{ $mat->nama_materi }}</h3>
                            <p class="text-xs text-gray-400 mt-1"><i class="far fa-calendar-alt mr-1"></i>Diupload: {{ $mat->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </div>
                
                {{-- Material Description & Attachments --}}
                <div class="p-6 space-y-4">
                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $mat->deskripsi_materi }}</p>
                    
                    {{-- YouTube video embed if exists --}}
                    @if($mat->youtube_link && $mat->getYoutubeEmbedUrl())
                        <div class="mt-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2"><i class="fab fa-youtube mr-1 text-red-500"></i> Video Pembelajaran</span>
                            <div class="aspect-video w-full max-w-2xl rounded-2xl overflow-hidden shadow-lg border border-slate-100">
                                <iframe class="w-full h-full" src="{{ $mat->getYoutubeEmbedUrl() }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif

                    {{-- Download File Attachment if exists --}}
                    @if($mat->file_materi)
                        <div class="pt-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2"><i class="fas fa-paperclip mr-1"></i> Lampiran File</span>
                            <a href="{{ asset('storage/' . $mat->file_materi) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 rounded-xl text-xs font-semibold transition active:scale-95">
                                <i class="fas fa-file-download text-cyan-600"></i>
                                <span>Unduh Materi ({{ basename($mat->file_materi) }})</span>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Connected Assignments inside this Material --}}
                @php $connectedAssignments = $assignments->where('materi_id', $mat->id); @endphp
                @if($connectedAssignments->count() > 0)
                    <div class="bg-cyan-50/20 border-t border-cyan-50/50 p-6 space-y-4">
                        <span class="text-xs font-bold text-cyan-700 uppercase tracking-wider flex items-center gap-2"><i class="fas fa-tasks"></i> Tugas Terkait Materi</span>
                        
                        @foreach($connectedAssignments as $t)
                            @php $sub = $submissions->firstWhere('tugas_id', $t->id); @endphp
                            <div id="tugas-{{ $t->id }}" class="bg-white rounded-2xl border border-cyan-100 p-5 shadow-sm space-y-4 scroll-mt-28">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 text-sm">{{ $t->nama_tugas }}</h4>
                                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $t->deskripsi_tugas }}</p>
                                        <div class="flex flex-wrap gap-4 mt-3 text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
                                            <span class="flex items-center gap-1"><i class="fas fa-calendar"></i> Deadline: {{ $t->tanggal_akhir_deadline?->translatedFormat('d M Y') ?? '-' }}</span>
                                            <span class="flex items-center gap-1"><i class="fas fa-star text-amber-500"></i> Nilai Maks: {{ $t->max_nilai }}</span>
                                            @if($t->file_tugas)
                                                <a href="{{ asset('storage/' . $t->file_tugas) }}" target="_blank" class="text-cyan-600 hover:underline flex items-center gap-1"><i class="fas fa-file-download"></i> Unduh File Soal</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-start sm:items-end justify-center">
                                        @if($sub)
                                            <div class="flex flex-col items-start sm:items-end gap-1">
                                                @if($sub->nilai !== null)
                                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100"><i class="fas fa-check-circle mr-1"></i>Nilai: {{ $sub->nilai }}</span>
                                                @else
                                                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100"><i class="fas fa-spinner mr-1"></i>Terkumpul</span>
                                                @endif
                                                <a href="{{ asset('storage/' . $sub->file_dikumpul) }}" target="_blank" class="text-[10px] text-cyan-600 font-bold hover:underline mt-1"><i class="fas fa-file-pdf mr-1"></i>File Pengumpulan Anda</a>
                                            </div>
                                        @else
                                            <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-100 mb-2 inline-block"><i class="fas fa-exclamation-circle mr-1"></i>Belum dikumpul</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Submission Form if not submitted --}}
                                @if(!$sub)
                                    <form method="POST" action="{{ route('mahasiswa.assignments.submit') }}" enctype="multipart/form-data" class="mt-4 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                                        @csrf
                                        <input type="hidden" name="tugas_id" value="{{ $t->id }}">
                                        <div class="flex-1">
                                            <input type="file" name="file" required accept=".pdf,.doc,.docx,.zip,.rar,.py,.ipynb,.xlsx,.html" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 transition">
                                        </div>
                                        <button type="submit" class="px-5 py-3 bg-cyan-600 text-white rounded-xl text-xs font-bold hover:bg-cyan-700 transition active:scale-95 shadow-md shadow-cyan-600/10 flex items-center justify-center gap-2"><i class="fas fa-upload text-[10px]"></i> Kumpulkan</button>
                                    </form>
                                @endif

                                @if($sub && $sub->feedback)
                                    <div class="mt-3 p-4 bg-cyan-50/50 rounded-xl text-xs text-cyan-800 border border-cyan-100/50"><i class="fas fa-comment mr-2 text-cyan-600"></i><b>Feedback Dosen:</b> {{ $sub->feedback }}</div>
                                @endif
							</div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300 shadow-inner"><i class="fas fa-book-open text-3xl"></i></div>
                <h3 class="font-bold text-slate-900 mb-1">Materi Belum Tersedia</h3>
                <p class="text-slate-500 text-xs">Dosen belum mengunggah materi pembelajaran untuk mata kuliah ini.</p>
            </div>
        @endforelse
    </div>

    {{-- Unconnected Assignments (General/Tugas Lainnya) --}}
    @php $unconnectedAssignments = $assignments->whereNull('materi_id'); @endphp
    @if($unconnectedAssignments->count() > 0)
        <h3 id="tugas-lainnya" class="text-lg font-bold text-gray-900 mt-10 mb-4 font-serif flex items-center gap-2 scroll-mt-28"><i class="fas fa-folder-open text-amber-500"></i> Tugas & Evaluasi Lainnya</h3>
        <div class="space-y-4">
            @foreach($unconnectedAssignments as $t)
                @php $sub = $submissions->firstWhere('tugas_id', $t->id); @endphp
                <div id="tugas-{{ $t->id }}" class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-4 scroll-mt-28">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 text-sm">{{ $t->nama_tugas }}</h4>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $t->deskripsi_tugas }}</p>
                            <div class="flex flex-wrap gap-4 mt-3 text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
                                <span class="flex items-center gap-1"><i class="fas fa-calendar"></i> Deadline: {{ $t->tanggal_akhir_deadline?->translatedFormat('d M Y') ?? '-' }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-star text-amber-500"></i> Nilai Maks: {{ $t->max_nilai }}</span>
                                @if($t->file_tugas)
                                    <a href="{{ asset('storage/' . $t->file_tugas) }}" target="_blank" class="text-cyan-600 hover:underline flex items-center gap-1"><i class="fas fa-file-download"></i> Unduh File Soal</a>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col items-start sm:items-end justify-center">
                            @if($sub)
                                <div class="flex flex-col items-start sm:items-end gap-1">
                                    @if($sub->nilai !== null)
                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100"><i class="fas fa-check-circle mr-1"></i>Nilai: {{ $sub->nilai }}</span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100"><i class="fas fa-spinner mr-1"></i>Terkumpul</span>
                                    @endif
                                    <a href="{{ asset('storage/' . $sub->file_dikumpul) }}" target="_blank" class="text-[10px] text-cyan-600 font-bold hover:underline mt-1"><i class="fas fa-file-pdf mr-1"></i>File Pengumpulan Anda</a>
                                </div>
                            @else
                                <span class="px-3 py-1.5 rounded-xl text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-100 mb-2 inline-block"><i class="fas fa-exclamation-circle mr-1"></i>Belum dikumpul</span>
                            @endif
                        </div>
                    </div>

                    {{-- Submission Form if not submitted --}}
                    @if(!$sub)
                        <form method="POST" action="{{ route('mahasiswa.assignments.submit') }}" enctype="multipart/form-data" class="mt-4 pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                            @csrf
                            <input type="hidden" name="tugas_id" value="{{ $t->id }}">
                            <div class="flex-1">
                                <input type="file" name="file" required accept=".pdf,.doc,.docx,.zip,.rar,.py,.ipynb,.xlsx,.html" class="w-full text-xs text-slate-500 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 transition">
                            </div>
                            <button type="submit" class="px-5 py-3 bg-cyan-600 text-white rounded-xl text-xs font-bold hover:bg-cyan-700 transition active:scale-95 shadow-md shadow-cyan-600/10 flex items-center justify-center gap-2"><i class="fas fa-upload text-[10px]"></i> Kumpulkan</button>
                        </form>
                    @endif

                    @if($sub && $sub->feedback)
                        <div class="mt-3 p-4 bg-cyan-50/50 rounded-xl text-xs text-cyan-800 border border-cyan-100/50"><i class="fas fa-comment mr-2 text-cyan-600"></i><b>Feedback Dosen:</b> {{ $sub->feedback }}</div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
        </div>
    </div>
</div>
@endsection
