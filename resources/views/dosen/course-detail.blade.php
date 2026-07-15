@extends('layouts.dashboard', ['activePage' => 'courses'])
@section('title', 'Kelola Kelas - Dosen - Polimicro')
@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('dosen.courses') }}" class="mb-6 inline-flex items-center text-xs font-bold text-slate-500 hover:text-slate-800 transition"><i class="fas fa-arrow-left mr-2"></i>Kembali ke Mata Kuliah Saya</a>
    
    {{-- Course Header --}}
    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-[2rem] p-8 text-white mb-8 shadow-xl shadow-slate-950/10 relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 opacity-10 text-9xl"><i class="fas fa-cog"></i></div>
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-widest text-cyan-400 mb-2 block">{{ $course->prodi->nama_prodi ?? '' }}</span>
                <h1 class="text-3xl font-extrabold mb-3 tracking-tight font-serif">{{ $course->nama_makul }}</h1>
                <p class="text-slate-300 text-sm max-w-2xl leading-relaxed">{{ $course->deskripsi ?: 'Kelola materi dan evaluasi untuk penugasan belajar mahasiswa secara terpusat.' }}</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                <button onclick="openMateriModal()" class="px-5 py-3.5 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-bold text-xs shadow-lg shadow-cyan-600/20 transition flex items-center justify-center gap-2"><i class="fas fa-plus text-[10px]"></i> Tambah Materi</button>
                <button onclick="openTugasModal()" class="px-5 py-3.5 bg-white/10 hover:bg-white/20 text-white rounded-xl border border-white/10 font-bold text-xs transition flex items-center justify-center gap-2"><i class="fas fa-tasks text-[10px]"></i> Buat Tugas</button>
                <a href="{{ route('dosen.quizzes.create', ['makul_id' => $course->id]) }}" class="px-5 py-3.5 bg-white/10 hover:bg-white/20 text-white rounded-xl border border-white/10 font-bold text-xs transition flex items-center justify-center gap-2"><i class="fas fa-question-circle text-[10px]"></i> Buat Kuis</a>
            </div>
        </div>
        
        <div class="flex flex-wrap items-center gap-6 pt-6 mt-6 border-t border-white/10 text-xs">
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
                <p class="text-slate-400 text-[10px]">Total Evaluasi</p>
            </div>
            <div class="h-8 w-px bg-white/10 hidden sm:block"></div>
            <div>
                <p class="font-bold text-white">{{ $course->prodi ? $course->prodi->pendaftaranDiterima->count() : 0 }} Mahasiswa</p>
                <p class="text-slate-400 text-[10px]">Terdaftar</p>
            </div>
        </div>
    </div>

    {{-- Materials and Assignments List --}}
    <h2 class="text-xl font-bold text-gray-900 mb-6 font-serif flex items-center gap-2"><i class="fas fa-folder-open text-cyan-600"></i> Struktur Materi & Tugas Kelas</h2>
    
    <div class="space-y-6">
        @forelse($materials as $index => $mat)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
                {{-- Material Header --}}
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
                    
                    {{-- Edit/Delete Material --}}
                    <div class="flex gap-2">
                        <button onclick="editMateri({{ $mat->id }}, '{{ addslashes($mat->nama_materi) }}', '{{ addslashes($mat->deskripsi_materi) }}', '{{ $mat->youtube_link }}')" class="px-3 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 transition border border-cyan-100"><i class="fas fa-edit"></i></button>
                        <form method="POST" action="{{ route('dosen.materials.destroy', $mat) }}" onsubmit="return confirm('Hapus materi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition border border-red-100"><i class="fas fa-trash"></i></button>
                        </form>
                    </div>
                </div>
                
                {{-- Material Content --}}
                <div class="p-6 space-y-4">
                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $mat->deskripsi_materi }}</p>
                    
                    {{-- YouTube video embed preview if exists --}}
                    @if($mat->youtube_link && $mat->getYoutubeEmbedUrl())
                        <div class="mt-4">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2"><i class="fab fa-youtube mr-1 text-red-500"></i> Preview Video YouTube</span>
                            <div class="aspect-video w-full max-w-xl rounded-2xl overflow-hidden shadow-md border border-slate-100 bg-black">
                                <iframe class="w-full h-full" src="{{ $mat->getYoutubeEmbedUrl() }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif

                    {{-- Download File Attachment if exists --}}
                    @if($mat->file_materi)
                        <div class="pt-2">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-2"><i class="fas fa-paperclip mr-1"></i> File Lampiran</span>
                            <a href="{{ asset('storage/' . $mat->file_materi) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-slate-50 border border-slate-200 text-slate-700 hover:bg-slate-100 rounded-xl text-xs font-semibold transition active:scale-95">
                                <i class="fas fa-file-download text-cyan-600"></i>
                                <span>Unduh Materi ({{ basename($mat->file_materi) }})</span>
                            </a>
                        </div>
                    @endif
                </div>

                {{-- Connected Assignments and Quizzes inside this Material --}}
                @php 
                    $connectedAssignments = $assignments->where('materi_id', $mat->id); 
                    $connectedQuizzes = $quizzes->where('materi_id', $mat->id);
                @endphp
                @if($connectedAssignments->count() > 0 || $connectedQuizzes->count() > 0)
                    <div class="bg-cyan-50/20 border-t border-cyan-50/50 p-6 space-y-4">
                        <span class="text-xs font-bold text-cyan-700 uppercase tracking-wider flex items-center gap-2"><i class="fas fa-tasks"></i> Tugas & Kuis Terkait Materi</span>
                        
                        @foreach($connectedAssignments as $t)
                            <div class="bg-white rounded-2xl border border-cyan-100 p-5 shadow-sm space-y-3">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 text-sm">{{ $t->nama_tugas }}</h4>
                                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $t->deskripsi_tugas }}</p>
                                        <div class="flex flex-wrap gap-4 mt-3 text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
                                            <span class="flex items-center gap-1"><i class="fas fa-calendar"></i> Deadline: {{ $t->tanggal_akhir_deadline?->format('d/m/Y') ?? '-' }}</span>
                                            <span class="flex items-center gap-1"><i class="fas fa-star text-amber-500"></i> Nilai Maks: {{ $t->max_nilai }}</span>
                                            <span class="flex items-center gap-1 text-cyan-600"><i class="fas fa-inbox"></i> {{ $t->submissions_count }} pengumpulan</span>
                                            @if($t->file_tugas)
                                                <a href="{{ asset('storage/' . $t->file_tugas) }}" target="_blank" class="text-cyan-600 hover:underline flex items-center gap-1"><i class="fas fa-file-download"></i> Unduh File Soal</a>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    {{-- Actions for task --}}
                                    <div class="flex gap-2 self-start">
                                        <a href="{{ route('dosen.submissions', ['tugas' => $t->id]) }}" class="px-4 py-2 bg-cyan-50 hover:bg-cyan-100 text-cyan-600 border border-cyan-100 rounded-lg text-xs font-bold transition flex items-center gap-1"><i class="fas fa-eye text-[10px]"></i> Pengumpulan</a>
                                        <button onclick="editTugas({{ $t->id }}, {{ $t->materi_id }}, '{{ addslashes($t->nama_tugas) }}', '{{ addslashes($t->deskripsi_tugas) }}', '{{ $t->tanggal_akhir_deadline?->format('Y-m-d') }}', {{ $t->max_nilai }})" class="px-3 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 border border-cyan-100 transition"><i class="fas fa-edit"></i></button>
                                        <form method="POST" action="{{ route('dosen.assignments.destroy', $t) }}" onsubmit="return confirm('Hapus tugas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition border border-red-100"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @foreach($connectedQuizzes as $q)
                            <div class="bg-white rounded-2xl border border-cyan-100 p-5 shadow-sm space-y-3">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 text-sm">Kuis: {{ $q->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $q->description }}</p>
                                        <div class="flex flex-wrap gap-4 mt-3 text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
                                            <span class="flex items-center gap-1"><i class="fas fa-clock text-cyan-500"></i> Waktu: {{ $q->time_limit_minutes }} Menit</span>
                                            <span class="flex items-center gap-1"><i class="fas fa-list-ol text-cyan-500"></i> {{ $q->questions->count() }} Soal</span>
                                            <span class="flex items-center gap-1 text-{{ $q->status === 'published' ? 'emerald' : 'slate' }}-600"><i class="fas fa-circle"></i> Status: {{ ucfirst($q->status) }}</span>
                                            <span class="flex items-center gap-1 text-cyan-600"><i class="fas fa-users"></i> {{ $q->attempts->count() }} Percobaan</span>
                                        </div>
                                    </div>
                                    
                                    {{-- Actions for quiz --}}
                                    <div class="flex gap-2 self-start">
                                        <a href="{{ route('dosen.quizzes.show', $q->id) }}" class="px-4 py-2 bg-cyan-50 hover:bg-cyan-100 text-cyan-600 border border-cyan-100 rounded-lg text-xs font-bold transition flex items-center gap-1"><i class="fas fa-eye text-[10px]"></i> Detail Kuis</a>
                                        <a href="{{ route('dosen.quizzes.edit', $q->id) }}" class="px-3 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 border border-cyan-100 transition"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('dosen.quizzes.destroy', $q->id) }}" onsubmit="return confirm('Hapus kuis ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition border border-red-100"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-3xl border border-gray-100">
                <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mx-auto mb-6 text-slate-300 shadow-inner"><i class="fas fa-book-open text-3xl"></i></div>
                <h3 class="font-bold text-slate-900 mb-1">Materi Belum Tersedia</h3>
                <p class="text-slate-500 text-xs mb-6">Anda belum mengunggah materi pembelajaran untuk mata kuliah ini.</p>
                <button onclick="openMateriModal()" class="px-5 py-3 bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-bold text-xs shadow-md">Tambah Materi Pertama</button>
            </div>
        @endforelse
    </div>

    {{-- Unconnected Assignments (General/Tugas Lainnya) --}}
    @php 
        $unconnectedAssignments = $assignments->whereNull('materi_id'); 
        $unconnectedQuizzes = $quizzes->whereNull('materi_id');
    @endphp
    @if($unconnectedAssignments->count() > 0 || $unconnectedQuizzes->count() > 0)
        <h3 class="text-lg font-bold text-gray-900 mt-10 mb-4 font-serif flex items-center gap-2"><i class="fas fa-folder-open text-amber-500"></i> Tugas & Evaluasi Lainnya</h3>
        <div class="space-y-4">
            @foreach($unconnectedAssignments as $t)
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 text-sm">{{ $t->nama_tugas }}</h4>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $t->deskripsi_tugas }}</p>
                            <div class="flex flex-wrap gap-4 mt-3 text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
                                <span class="flex items-center gap-1"><i class="fas fa-calendar"></i> Deadline: {{ $t->tanggal_akhir_deadline?->format('d/m/Y') ?? '-' }}</span>
                                <span class="flex items-center gap-1"><i class="fas fa-star text-amber-500"></i> Nilai Maks: {{ $t->max_nilai }}</span>
                                <span class="flex items-center gap-1 text-cyan-600"><i class="fas fa-inbox"></i> {{ $t->submissions_count }} pengumpulan</span>
                                @if($t->file_tugas)
                                    <a href="{{ asset('storage/' . $t->file_tugas) }}" target="_blank" class="text-cyan-600 hover:underline flex items-center gap-1"><i class="fas fa-file-download"></i> Unduh File Soal</a>
                                @endif
                            </div>
                        </div>
                        
                        {{-- Actions for task --}}
                        <div class="flex gap-2 self-start">
                            <a href="{{ route('dosen.submissions', ['tugas' => $t->id]) }}" class="px-4 py-2 bg-cyan-50 hover:bg-cyan-100 text-cyan-600 border border-cyan-100 rounded-lg text-xs font-bold transition flex items-center gap-1"><i class="fas fa-eye text-[10px]"></i> Pengumpulan</a>
                            <button onclick="editTugas({{ $t->id }}, null, '{{ addslashes($t->nama_tugas) }}', '{{ addslashes($t->deskripsi_tugas) }}', '{{ $t->tanggal_akhir_deadline?->format('Y-m-d') }}', {{ $t->max_nilai }})" class="px-3 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 border border-cyan-100 transition"><i class="fas fa-edit"></i></button>
                            <form method="POST" action="{{ route('dosen.assignments.destroy', $t) }}" onsubmit="return confirm('Hapus tugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition border border-red-100"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach

            @foreach($unconnectedQuizzes as $q)
                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 text-sm">Kuis: {{ $q->title }}</h4>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">{{ $q->description }}</p>
                            <div class="flex flex-wrap gap-4 mt-3 text-[10px] text-gray-400 font-semibold uppercase tracking-wider">
                                <span class="flex items-center gap-1"><i class="fas fa-clock text-cyan-500"></i> Waktu: {{ $q->time_limit_minutes }} Menit</span>
                                <span class="flex items-center gap-1"><i class="fas fa-list-ol text-cyan-500"></i> {{ $q->questions->count() }} Soal</span>
                                <span class="flex items-center gap-1 text-{{ $q->status === 'published' ? 'emerald' : 'slate' }}-600"><i class="fas fa-circle"></i> Status: {{ ucfirst($q->status) }}</span>
                                <span class="flex items-center gap-1 text-cyan-600"><i class="fas fa-users"></i> {{ $q->attempts->count() }} Percobaan</span>
                            </div>
                        </div>
                        
                        {{-- Actions for quiz --}}
                        <div class="flex gap-2 self-start">
                            <a href="{{ route('dosen.quizzes.show', $q->id) }}" class="px-4 py-2 bg-cyan-50 hover:bg-cyan-100 text-cyan-600 border border-cyan-100 rounded-lg text-xs font-bold transition flex items-center gap-1"><i class="fas fa-eye text-[10px]"></i> Detail Kuis</a>
                            <a href="{{ route('dosen.quizzes.edit', $q->id) }}" class="px-3 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 border border-cyan-100 transition"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('dosen.quizzes.destroy', $q->id) }}" onsubmit="return confirm('Hapus kuis ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-xs hover:bg-red-100 transition border border-red-100"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- MODALS SECTION --}}
@push('modals')
{{-- Material Add/Edit Modal --}}
<div id="materi-modal" class="fixed inset-0 z-50 hidden items-center justify-center shadow-2xl" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800" id="m-modal-title">Tambah Materi</h3>
            <button type="button" onclick="closeMateriModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="materi-form" method="POST" action="{{ route('dosen.materials.store') }}" enctype="multipart/form-data" class="space-y-4" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menyimpan...'">
            @csrf
            <div id="m-method-field"></div>
            <input type="hidden" name="makul_id" value="{{ $course->id }}">
            
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Nama Materi <span class="text-red-400">*</span></label><input type="text" name="nama_materi" id="m-nama" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Deskripsi <span class="text-red-400">*</span></label><textarea name="deskripsi_materi" id="m-deskripsi" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></textarea></div>
            
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Tautan Video YouTube (Opsional)</label>
                <input type="url" name="youtube_link" id="m-youtube" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">File Materi (PDF/DOC/ZIP, Max: 2MB)</label>
                <input type="file" name="file_materi" accept=".pdf,.doc,.docx,.zip,.rar" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100 transition">
            </div>
            
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeMateriModal()" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 bg-cyan-600 text-white rounded-xl font-semibold hover:bg-cyan-700 transition flex items-center justify-center gap-2"><i class="fas fa-save text-sm"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Assignment Add/Edit Modal --}}
<div id="tugas-modal" class="fixed inset-0 z-50 hidden items-center justify-center shadow-2xl" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl p-8 max-w-lg w-full mx-4 fade-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold font-serif text-slate-800" id="t-modal-title">Buat Tugas Baru</h3>
            <button type="button" onclick="closeTugasModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600 transition"><i class="fas fa-times text-sm"></i></button>
        </div>
        <form id="tugas-form" method="POST" action="{{ route('dosen.assignments.store') }}" enctype="multipart/form-data" class="space-y-4" onsubmit="this.querySelector('[data-submit]').disabled=true;this.querySelector('[data-submit]').innerHTML='<i class=\'fas fa-spinner fa-spin text-sm\'></i> Menyimpan...'">
            @csrf
            <div id="t-method-field"></div>
            <input type="hidden" name="makul_id" value="{{ $course->id }}">
            
            <div>
                <label class="block text-sm font-medium text-slate-600 mb-1">Hubungkan dengan Materi (Opsional)</label>
                <select name="materi_id" id="t-materi" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
                    <option value="">-- Tidak dikaitkan dengan materi --</option>
                    @foreach($materials as $mat)
                        <option value="{{ $mat->id }}">{{ $mat->nama_materi }}</option>
                    @endforeach
                </select>
            </div>
            
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Judul Tugas <span class="text-red-400">*</span></label><input type="text" name="nama_tugas" id="t-nama" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Deskripsi <span class="text-red-400">*</span></label><textarea name="deskripsi_tugas" id="t-deskripsi" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></textarea></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">File Tugas (Opsional)</label><input type="file" name="file_tugas" class="w-full text-xs file:mr-2 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-cyan-50 file:text-cyan-700"></div>
            
            <div class="grid grid-cols-2 gap-4">
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Deadline <span class="text-red-400">*</span></label><input type="date" name="tanggal_akhir_deadline" id="t-deadline" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
                <div><label class="block text-sm font-medium text-slate-600 mb-1">Nilai Maks</label><input type="number" name="max_nilai" id="t-nilai" value="100" min="1" max="100" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"></div>
            </div>
            
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="closeTugasModal()" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" data-submit class="flex-1 py-3 bg-cyan-600 text-white rounded-xl font-semibold hover:bg-cyan-700 transition flex items-center justify-center gap-2"><i class="fas fa-save text-sm"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endpush

@push('scripts')
<script>
// --- Materi Modals JS ---
function openMateriModal() {
    document.getElementById('m-modal-title').innerText = 'Tambah Materi';
    document.getElementById('materi-form').action = "{{ route('dosen.materials.store') }}";
    document.getElementById('m-method-field').innerHTML = '';
    document.getElementById('m-nama').value = '';
    document.getElementById('m-deskripsi').value = '';
    document.getElementById('m-youtube').value = '';
    document.getElementById('materi-modal').classList.remove('hidden'); 
    document.getElementById('materi-modal').classList.add('flex'); 
}
function editMateri(id, nama, deskripsi, youtubeLink) {
    document.getElementById('m-modal-title').innerText = 'Edit Materi';
    document.getElementById('materi-form').action = "/dosen/materials/" + id;
    document.getElementById('m-method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('m-nama').value = nama;
    document.getElementById('m-deskripsi').value = deskripsi;
    document.getElementById('m-youtube').value = youtubeLink || '';
    document.getElementById('materi-modal').classList.remove('hidden'); 
    document.getElementById('materi-modal').classList.add('flex'); 
}
function closeMateriModal() { 
    document.getElementById('materi-modal').classList.add('hidden'); 
    document.getElementById('materi-modal').classList.remove('flex'); 
}

// --- Tugas Modals JS ---
function openTugasModal() {
    document.getElementById('t-modal-title').innerText = 'Buat Tugas Baru';
    document.getElementById('tugas-form').action = "{{ route('dosen.assignments.store') }}";
    document.getElementById('t-method-field').innerHTML = '';
    document.getElementById('t-materi').value = '';
    document.getElementById('t-nama').value = '';
    document.getElementById('t-deskripsi').value = '';
    document.getElementById('t-deadline').value = '';
    document.getElementById('t-nilai').value = 100;
    document.getElementById('tugas-modal').classList.remove('hidden'); 
    document.getElementById('tugas-modal').classList.add('flex'); 
}
function editTugas(id, materiId, nama, deskripsi, deadline, nilai) {
    document.getElementById('t-modal-title').innerText = 'Edit Tugas';
    document.getElementById('tugas-form').action = "/dosen/assignments/" + id;
    document.getElementById('t-method-field').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('t-materi').value = materiId || '';
    document.getElementById('t-nama').value = nama;
    document.getElementById('t-deskripsi').value = deskripsi;
    document.getElementById('t-deadline').value = deadline;
    document.getElementById('t-nilai').value = nilai;
    document.getElementById('tugas-modal').classList.remove('hidden'); 
    document.getElementById('tugas-modal').classList.add('flex'); 
}
function closeTugasModal() { 
    document.getElementById('tugas-modal').classList.add('hidden'); 
    document.getElementById('tugas-modal').classList.remove('flex'); 
}

// Close modals when clicking backdrop
document.getElementById('materi-modal').addEventListener('click', function(e) { if (e.target === this) closeMateriModal(); });
document.getElementById('tugas-modal').addEventListener('click', function(e) { if (e.target === this) closeTugasModal(); });
document.addEventListener('keydown', function(e) { 
    if (e.key === 'Escape') {
        closeMateriModal();
        closeTugasModal();
    }
});
</script>
@endpush
@endsection
