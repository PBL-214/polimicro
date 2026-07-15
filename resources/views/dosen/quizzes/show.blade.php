@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Detail Kuis: {{ $quiz->title }}</h1>
        <a href="{{ route('dosen.quizzes.index') }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Quiz Info -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Informasi</h3>
                <dl class="space-y-3 text-sm">
                    <div>
                        <dt class="text-gray-500">Mata Kuliah</dt>
                        <dd class="font-medium">{{ $quiz->makul->nama_makul }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Materi</dt>
                        <dd class="font-medium">{{ $quiz->materi ? $quiz->materi->judul : 'Semua Materi' }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Status</dt>
                        <dd class="font-medium">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $quiz->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($quiz->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Durasi Waktu</dt>
                        <dd class="font-medium">{{ $quiz->time_limit_minutes }} Menit</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500">Total Soal</dt>
                        <dd class="font-medium">{{ $quiz->questions->count() }} Soal</dd>
                    </div>
                </dl>
                <div class="mt-6 pt-4 border-t">
                    <a href="{{ route('dosen.quizzes.edit', $quiz) }}" class="block w-full text-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Edit Kuis
                    </a>
                </div>
            </div>
        </div>

        <!-- Questions & Attempts -->
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Daftar Pertanyaan</h3>
                <div class="space-y-6">
                    @foreach($quiz->questions as $index => $question)
                        <div class="border border-gray-100 p-4 rounded-lg bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <h4 class="font-medium text-gray-900">{{ $index + 1 }}. {{ $question->question_text }}</h4>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $question->points }} Poin</span>
                            </div>
                            <ul class="space-y-2 text-sm pl-4">
                                @foreach($question->options as $option)
                                    <li class="flex items-center space-x-2">
                                        @if($option->is_correct)
                                            <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            <span class="font-medium text-green-700">{{ $option->option_text }}</span>
                                        @else
                                            <svg class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <circle cx="12" cy="12" r="10" />
                                            </svg>
                                            <span class="text-gray-600">{{ $option->option_text }}</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Riwayat Pengerjaan Mahasiswa</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Mulai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Selesai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($quiz->attempts as $attempt)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $attempt->user->name }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $attempt->start_time->format('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ $attempt->end_time ? $attempt->end_time->format('d M Y, H:i') : 'Sedang mengerjakan...' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium {{ $attempt->score !== null ? 'text-blue-600' : 'text-gray-400' }}">
                                    {{ $attempt->score !== null ? number_format($attempt->score, 2) : '-' }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500">
                                    Belum ada mahasiswa yang mengerjakan kuis ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
