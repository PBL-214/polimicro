@extends('layouts.dashboard', ['activePage' => 'dashboard'])
@section('title', 'Dashboard Mahasiswa - Polimicro')

@push('styles')
<style>
    /* Countdown Timer Styles */
    .countdown-box {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .time-block {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9; }
    .fc-header-toolbar { padding: 1rem; margin-bottom: 0 !important; border-bottom: 1px solid #f1f5f9; }
    .fc-day-today { background-color: #f8fafc !important; }
    .fc-event { border: none; border-radius: 4px; padding: 2px 4px; font-size: 0.75rem; font-weight: 600; cursor: pointer; }
</style>
@endpush

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, {{ explode(' ', $user->name)[0] }}! 👋</h1>
        <p class="text-gray-500 mt-1">Berikut ringkasan aktivitas pembelajaran Anda</p>
    </div>

    @if($maxActiveDate)
    <div class="countdown-box rounded-3xl p-6 text-white min-w-[320px]">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="font-bold font-serif text-lg text-cyan-400">Sisa Waktu Akses</h3>
                <p class="text-xs text-slate-400">Batas akhir: {{ $maxActiveDate->translatedFormat('d M Y') }}</p>
            </div>
            <i class="fas fa-hourglass-half text-2xl text-cyan-500 opacity-50"></i>
        </div>
        <div class="flex gap-3 justify-center" id="countdown-timer">
            <div class="time-block rounded-xl px-4 py-2 text-center flex-1">
                <span class="text-2xl font-bold font-mono" id="cd-days">00</span>
                <p class="text-[10px] uppercase tracking-wider text-slate-300 font-semibold mt-1">Hari</p>
            </div>
            <div class="time-block rounded-xl px-4 py-2 text-center flex-1">
                <span class="text-2xl font-bold font-mono" id="cd-hours">00</span>
                <p class="text-[10px] uppercase tracking-wider text-slate-300 font-semibold mt-1">Jam</p>
            </div>
            <div class="time-block rounded-xl px-4 py-2 text-center flex-1">
                <span class="text-2xl font-bold font-mono" id="cd-mins">00</span>
                <p class="text-[10px] uppercase tracking-wider text-slate-300 font-semibold mt-1">Mnt</p>
            </div>
            <div class="time-block rounded-xl px-4 py-2 text-center flex-1">
                <span class="text-2xl font-bold font-mono text-cyan-400" id="cd-secs">00</span>
                <p class="text-[10px] uppercase tracking-wider text-slate-300 font-semibold mt-1">Dtk</p>
            </div>
        </div>
    </div>
    @endif
</div>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center shadow-sm"><i class="fas fa-book-open text-cyan-600"></i></div><span class="text-xs text-cyan-600 font-medium"><i class="fas fa-arrow-up mr-1"></i>Aktif</span></div>
        <p class="text-2xl font-bold text-gray-900">{{ $enrolled->count() }}</p><p class="text-xs text-gray-400 mt-1">Mata Kuliah</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shadow-sm"><i class="fas fa-tasks text-blue-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $submissions->count() }}</p><p class="text-xs text-gray-400 mt-1">Tugas Dikumpul</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center shadow-sm"><i class="fas fa-star text-amber-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $avgGrade }}</p><p class="text-xs text-gray-400 mt-1">Rata-rata Nilai</p>
    </div>
    <div class="bg-white rounded-2xl p-5 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-3"><div class="w-10 h-10 rounded-xl bg-cyan-100 flex items-center justify-center shadow-sm"><i class="fas fa-certificate text-cyan-600"></i></div></div>
        <p class="text-2xl font-bold text-gray-900">{{ $certs->count() }}</p><p class="text-xs text-gray-400 mt-1">Sertifikat</p>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6 mb-8">
    {{-- Enrolled Courses - Visual Roadmap --}}
    <div class="lg:col-span-1 bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
        <div class="flex flex-col mb-6">
            <h2 class="text-xl font-bold text-gray-900 font-serif mb-1">Alur Belajar Saya</h2>
            <p class="text-xs text-gray-400 mb-3">Urutan materi hasil maksimal</p>
            <a href="{{ route('mahasiswa.courses') }}" class="px-3 py-1.5 text-center bg-slate-50 text-slate-600 rounded-lg text-xs font-bold hover:bg-slate-100 transition border border-slate-200">Katalog</a>
        </div>
        <div class="relative space-y-6 pl-2">
            <div class="roadmap-connector" style="left: 1.25rem;"></div>
            @forelse($enrolled->take(4) as $m)
                <div class="flex items-center gap-4 group relative z-10">
                    <div class="w-8 h-8 rounded-xl bg-cyan-600 flex items-center justify-center text-white shadow-lg shadow-cyan-600/30 group-hover:scale-110 transition duration-300 flex-shrink-0 text-xs"><i class="fas fa-book"></i></div>
                    <a href="{{ route('mahasiswa.courses.show', $m->id) }}" class="flex-1 p-3 rounded-xl bg-slate-50 border border-transparent hover:border-cyan-200 hover:bg-white transition-all duration-300 group-hover:shadow-lg group-hover:shadow-black/5">
                        <p class="font-bold text-gray-900 group-hover:text-cyan-600 transition text-sm leading-tight">{{ $m->nama_makul }}</p>
                        <span class="text-[10px] font-bold text-cyan-600 bg-cyan-50 px-2 py-0.5 rounded-md border border-cyan-100 mt-2 inline-block">{{ $m->progress }}% Selesai</span>
                    </a>
                </div>
            @empty
                <x-empty-state 
                    icon="fas fa-route" 
                    title="Mulai" 
                    description="Belum ambil kelas"
                    actionText="Jelajahi"
                    :actionUrl="route('programs')"
                />
            @endforelse
        </div>
    </div>

    {{-- Deadline Calendar --}}
    <div class="lg:col-span-2 bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm flex flex-col">
        <div class="p-6 pb-0 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-2 font-serif"><i class="fas fa-calendar-alt text-amber-500 mr-2"></i>Kalender Deadline</h2>
            <p class="text-sm text-gray-400 mb-4">Pantau jadwal pengumpulan tugas Anda</p>
        </div>
        <div class="flex-1 p-4" id="calendar"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Countdown Timer Logic
        @if($maxActiveDate)
            const countDownDate = new Date("{{ $maxActiveDate->toIso8601String() }}").getTime();

            const x = setInterval(function() {
                const now = new Date().getTime();
                const distance = countDownDate - now;

                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("cd-days").innerHTML = "00";
                    document.getElementById("cd-hours").innerHTML = "00";
                    document.getElementById("cd-mins").innerHTML = "00";
                    document.getElementById("cd-secs").innerHTML = "00";
                    
                    // Reload to trigger middleware lock
                    window.location.reload();
                    return;
                }

                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("cd-days").innerHTML = days.toString().padStart(2, '0');
                document.getElementById("cd-hours").innerHTML = hours.toString().padStart(2, '0');
                document.getElementById("cd-mins").innerHTML = minutes.toString().padStart(2, '0');
                document.getElementById("cd-secs").innerHTML = seconds.toString().padStart(2, '0');
            }, 1000);
        @endif

        // Calendar Logic
        const calendarEl = document.getElementById('calendar');
        if (calendarEl) {
            const calendarEvents = {!! $calendarEventsJson ?? '[]' !!};
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'title',
                    right: 'prev,next today'
                },
                buttonText: {
                    today: 'Hari Ini'
                },
                events: calendarEvents.map(e => ({
                    ...e,
                    color: '#f59e0b', // amber-500
                    textColor: '#fff'
                })),
                height: 'auto',
                eventClick: function(info) {
                    if (info.event.url) {
                        info.jsEvent.preventDefault();
                        window.location.href = info.event.url;
                    }
                }
            });
            calendar.render();
        }
    });
</script>
@endpush
