@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-blue-600 px-6 py-8 text-center text-white">
            <h1 class="text-3xl font-bold mb-2">{{ $quiz->title }}</h1>
            <p class="text-blue-100">{{ $quiz->makul->nama_makul }}</p>
        </div>
        
        <div class="p-8">
            <div class="prose max-w-none text-gray-700 mb-8">
                @if($quiz->description)
                    <p>{{ $quiz->description }}</p>
                @endif
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Waktu pengerjaan: <strong>{{ $quiz->time_limit_minutes }} Menit</strong></li>
                    <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg> Jumlah Soal: <strong>{{ $quiz->questions->count() }} Soal</strong></li>
                </ul>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Penting: Setelah tombol "Mulai Kerjakan" ditekan, waktu akan terus berjalan meskipun Anda menutup halaman. Pastikan koneksi internet Anda stabil.
                        </p>
                    </div>
                </div>
            </div>

            <form action="{{ route('mahasiswa.courses.quizzes.start', ['course' => $course, 'quiz' => $quiz->id]) }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg transition-transform transform hover:-translate-y-1">
                    Mulai Kerjakan Kuis Sekarang
                </button>
            </form>
            <div class="mt-4 text-center">
                <a href="{{ route('mahasiswa.courses.show', $course) }}" class="text-sm text-gray-500 hover:text-gray-700">Kembali ke Detail Mata Kuliah</a>
            </div>
        </div>
    </div>
</div>
@endsection
