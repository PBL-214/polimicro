@extends('layouts.dashboard', ['activePage' => 'students'])
@section('title', 'Daftar Mahasiswa - Dosen - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-2">Daftar Mahasiswa</h1>
<p class="text-gray-500 mb-6">Mahasiswa yang terdaftar per mata kuliah</p>
@foreach($myMatkul as $m)
    @php $enrollments = $m->prodi->pendaftaranDiterima()->with('mahasiswa')->get(); @endphp
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden mb-6">
        <div class="p-5 border-b border-gray-50 flex justify-between"><h3 class="font-bold">{{ $m->nama_makul }}</h3><span class="text-sm text-gray-400">{{ $enrollments->count() }} mahasiswa</span></div>
        <div class="overflow-x-auto"><table class="w-full text-sm">
            <thead><tr class="bg-gray-50" style="background:#faf8f5"><th class="px-5 py-3 text-left font-semibold text-gray-600">No</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Mahasiswa</th><th class="px-5 py-3 text-left font-semibold text-gray-600">NIM</th><th class="px-5 py-3 text-left font-semibold text-gray-600">Email</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
            @forelse($enrollments as $i => $e)
                @if($e->mahasiswa)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-4 text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-5 py-4"><div class="flex items-center gap-3"><div class="w-8 h-8 rounded-full bg-cyan-100 flex items-center justify-center text-xs font-bold text-cyan-700">{{ $e->mahasiswa->getInitials() }}</div><span class="font-medium">{{ $e->mahasiswa->name }}</span></div></td>
                    <td class="px-5 py-4 text-gray-500 font-mono text-xs">{{ $e->mahasiswa->nim ?? '-' }}</td>
                    <td class="px-5 py-4 text-gray-500 text-xs">{{ $e->mahasiswa->email }}</td>
                </tr>
                @endif
            @empty
                <tr><td colspan="4" class="px-5 py-12 text-center text-gray-400">Belum ada mahasiswa terdaftar</td></tr>
            @endforelse
            </tbody>
        </table></div>
    </div>
@endforeach

<div class="mt-6">
    {{ $myMatkul->links() }}
</div>
@endsection
