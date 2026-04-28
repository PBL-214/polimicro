@extends('layouts.dashboard', ['activePage' => 'submissions'])
@section('title', 'Pengumpulan Tugas - Dosen - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-2">Pengumpulan Tugas</h1>
<p class="text-gray-500 mb-6">Lihat dan nilai tugas yang dikumpulkan mahasiswa</p>
<select class="px-4 py-3 rounded-xl border border-gray-200 bg-white text-sm mb-6" onchange="window.location='{{ route('dosen.submissions') }}?tugas='+this.value">
    <option value="">Semua Tugas</option>
    @foreach($allTugas as $t)<option value="{{ $t->id }}" {{ $filterTugas == $t->id ? 'selected' : '' }}>{{ $t->nama_tugas }}</option>@endforeach
</select>
@php $filtered = $filterTugas ? $allTugas->where('id', $filterTugas) : $allTugas; @endphp
@foreach($filtered as $t)
    @php $subs = $t->submissions()->with('mahasiswa')->get(); @endphp
    @if($subs->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-100 mb-4 overflow-hidden">
        <div class="p-5 border-b border-gray-50"><h3 class="font-bold">{{ $t->nama_tugas }}</h3><p class="text-xs text-gray-400">{{ $t->makul->nama_makul ?? '' }} • Deadline: {{ $t->tanggal_akhir_deadline?->format('d/m/Y') ?? '-' }}</p></div>
        <div class="overflow-x-auto"><table class="w-full text-sm">
            <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">Mahasiswa</th><th class="px-5 py-3 text-left font-semibold text-gray-600">File</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Tanggal</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Nilai</th><th class="px-5 py-3 text-center font-semibold text-gray-600">Aksi</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
            @foreach($subs as $s)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-xs font-bold text-cyan-700">{{ $s->mahasiswa ? $s->mahasiswa->getInitials() : '?' }}</div><div><p class="font-medium">{{ $s->mahasiswa->name ?? '-' }}</p><p class="text-xs text-gray-400">{{ $s->mahasiswa->nim ?? '' }}</p></div></div></td>
                    <td class="px-5 py-4 text-gray-500 text-xs">
                        @if($s->file_dikumpul)
                            <a href="{{ asset('storage/' . $s->file_dikumpul) }}" target="_blank" class="text-cyan-600 hover:text-cyan-700 font-semibold"><i class="fas fa-download mr-1"></i>Unduh</a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-5 py-4 text-gray-400 text-xs">{{ $s->waktu_kumpul?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td class="px-5 py-4 text-center font-bold">{{ $s->nilai !== null ? $s->nilai : '-' }}</td>
                    <td class="px-5 py-4 text-center"><button onclick="openGrade({{ $s->id }},'{{ $s->mahasiswa->name ?? '-' }}','{{ $t->nama_tugas }}',{{ $s->nilai ?? 'null' }},'{{ $s->feedback ?? '' }}')" class="px-4 py-2 bg-cyan-50 text-cyan-600 rounded-lg text-xs hover:bg-cyan-100 font-medium"><i class="fas fa-pen mr-1"></i>{{ $s->nilai !== null ? 'Edit' : 'Nilai' }}</button></td>
                </tr>
            @endforeach
            </tbody>
        </table></div>
    </div>
    @endif
@endforeach

@push('modals')
{{-- Grade Modal --}}
<div id="grade-modal" class="fixed inset-0 z-50 hidden items-center justify-center" style="background:rgba(15,23,42,0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 fade-in">
        <h3 class="text-xl font-bold mb-4">Beri Nilai</h3>
        <form id="grade-form" method="POST" class="space-y-4">@csrf @method('PUT')
            <p class="text-sm text-slate-600 font-semibold" id="gf-info"></p>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Nilai (0-100)</label><input type="number" name="nilai" id="gf-nilai" min="0" max="100" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-cyan-500 focus:border-cyan-500 transition"></div>
            <div><label class="block text-sm font-medium text-slate-600 mb-1">Feedback</label><textarea name="feedback" id="gf-feedback" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-cyan-500 focus:border-cyan-500 transition"></textarea></div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('grade-modal').classList.add('hidden');document.getElementById('grade-modal').classList.remove('flex');" class="flex-1 py-3 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-cyan-600 text-white hover:bg-cyan-700 rounded-xl font-semibold transition">Simpan Nilai</button>
            </div>
        </form>
    </div>
</div>
@endpush
<script>
function openGrade(id, mhs, tugas, nilai, feedback) {
    document.getElementById('grade-form').action = '/dosen/submissions/' + id + '/grade';
    document.getElementById('gf-info').textContent = mhs + ' - ' + tugas;
    document.getElementById('gf-nilai').value = nilai || '';
    document.getElementById('gf-feedback').value = feedback || '';
    document.getElementById('grade-modal').classList.remove('hidden');
    document.getElementById('grade-modal').classList.add('flex');
}
</script>
@endsection
