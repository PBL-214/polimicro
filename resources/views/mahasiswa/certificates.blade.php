@extends('layouts.dashboard', ['activePage' => 'certificates'])
@section('title', 'Sertifikat - Polimicro')
@section('content')
<h1 class="text-2xl font-bold text-slate-900 mb-2 font-serif">Sertifikat Saya</h1>
<p class="text-slate-500 mb-6">Download sertifikat kelulusan program</p>
<div class="grid md:grid-cols-2 gap-6">
    @forelse($certs as $c)
        <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden card-hover shadow-sm">
            <div class="bg-slate-50 p-6 text-center border-b border-slate-100">
                <div class="w-16 h-16 mx-auto rounded-full bg-white shadow-sm flex items-center justify-center mb-3"><i class="fas fa-award text-cyan-600 text-2xl"></i></div>
                <h3 class="font-bold text-slate-800 text-lg font-serif">Sertifikat Kelulusan</h3>
                <p class="text-slate-600 font-medium">{{ $c->prodi->nama_prodi ?? '-' }}</p>
            </div>
            <div class="p-6">
                <div class="space-y-3 text-sm mb-6">
                    <div class="flex justify-between"><span class="text-slate-500">Nomor</span><span class="font-medium font-mono text-xs text-slate-700">{{ $c->nomor_sertifikat }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Tanggal Terbit</span><span class="font-medium text-slate-700">{{ $c->tanggal_terbit->format('d/m/Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500">Status</span><span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-50 text-cyan-700">{{ ucfirst($c->status) }}</span></div>
                </div>
                @if($c->file_sertifikat)
                    <a href="{{ asset('storage/' . $c->file_sertifikat) }}" target="_blank" class="block w-full py-3 text-center bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl font-semibold transition"><i class="fas fa-download mr-2"></i>Unduh Sertifikat</a>
                @else
                    <button disabled class="w-full py-3 bg-slate-100 text-slate-400 rounded-xl font-semibold cursor-not-allowed"><i class="fas fa-clock mr-2"></i>File Belum Tersedia</button>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl border border-slate-100 shadow-sm"><i class="fas fa-certificate text-4xl text-slate-300 mb-4 block"></i><p class="text-slate-500">Belum ada sertifikat.</p></div>
    @endforelse
</div>

<div class="mt-8">
    {{ $certs->links() }}
</div>
@endsection
