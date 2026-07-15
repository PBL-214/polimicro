@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Hasil Kuis</h1>
        <a href="{{ route('mahasiswa.courses.show', $course) }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali ke Detail Mata Kuliah</a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="bg-blue-600 px-6 py-6 text-white text-center">
            <h2 class="text-2xl font-bold">{{ $attempt->quiz->title }}</h2>
            <p class="text-blue-100 mt-1">{{ $attempt->quiz->makul->nama_makul }}</p>
        </div>
        
        <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6 text-center divide-y md:divide-y-0 md:divide-x divide-gray-200">
            <div class="p-4">
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Skor Akhir</p>
                <p class="mt-2 text-4xl font-extrabold text-blue-600">{{ number_format($attempt->score, 1) }}</p>
            </div>
            <div class="p-4">
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Waktu Pengerjaan</p>
                @php
                    $duration = $attempt->start_time->diffInMinutes($attempt->end_time);
                @endphp
                <p class="mt-2 text-2xl font-bold text-gray-800">{{ $duration }} Menit</p>
                <p class="text-xs text-gray-500 mt-1">{{ $attempt->start_time->format('d M Y, H:i') }}</p>
            </div>
            <div class="p-4">
                <p class="text-sm text-gray-500 font-medium uppercase tracking-wide">Total Soal</p>
                <p class="mt-2 text-2xl font-bold text-gray-800">{{ $attempt->quiz->questions->count() }}</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2">Detail Jawaban</h3>
        
        @foreach($attempt->quiz->questions as $index => $question)
            @php
                $userAnswer = $attempt->answers->where('quiz_question_id', $question->id)->first();
                $selectedOptionId = $userAnswer ? $userAnswer->quiz_option_id : null;
                
                $isCorrect = false;
                if ($selectedOptionId) {
                    $selectedOption = $question->options->where('id', $selectedOptionId)->first();
                    $isCorrect = $selectedOption && $selectedOption->is_correct;
                }
            @endphp
            
            <div class="bg-white p-6 rounded-xl shadow-sm border {{ $isCorrect ? 'border-green-200' : 'border-red-200' }}">
                <div class="flex justify-between items-start mb-4">
                    <h4 class="text-lg font-medium text-gray-900">
                        <span class="mr-2 {{ $isCorrect ? 'text-green-600' : 'text-red-600' }} font-bold">{{ $index + 1 }}.</span> 
                        {{ $question->question_text }}
                    </h4>
                    <span class="{{ $isCorrect ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-xs font-bold px-2.5 py-0.5 rounded ml-4 whitespace-nowrap">
                        {{ $isCorrect ? $question->points . ' / ' . $question->points . ' Poin' : '0 / ' . $question->points . ' Poin' }}
                    </span>
                </div>
                
                <div class="space-y-3 mt-4 ml-6">
                    @foreach($question->options as $option)
                        @php
                            $isSelected = $option->id == $selectedOptionId;
                            $isActuallyCorrect = $option->is_correct;
                            
                            $bgClass = 'bg-gray-50';
                            $borderClass = 'border-gray-200';
                            $icon = '';
                            
                            if ($isActuallyCorrect) {
                                $bgClass = 'bg-green-50';
                                $borderClass = 'border-green-300';
                                $icon = '<svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
                            } elseif ($isSelected && !$isActuallyCorrect) {
                                $bgClass = 'bg-red-50';
                                $borderClass = 'border-red-300';
                                $icon = '<svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>';
                            } else {
                                $icon = '<div class="w-5 h-5 mr-2"></div>';
                            }
                        @endphp
                        
                        <div class="flex items-center p-3 rounded-lg border {{ $borderClass }} {{ $bgClass }}">
                            {!! $icon !!}
                            <div class="text-sm">
                                <span class="{{ $isActuallyCorrect ? 'font-bold text-green-800' : ($isSelected ? 'font-bold text-red-800' : 'text-gray-700') }}">
                                    {{ $option->option_text }}
                                </span>
                                @if($isSelected)
                                    <span class="ml-2 text-xs text-gray-500 italic">(Jawaban Anda)</span>
                                @endif
                                @if($isActuallyCorrect && !$isSelected)
                                    <span class="ml-2 text-xs text-green-600 italic">(Jawaban Benar)</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
