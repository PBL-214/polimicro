@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 sticky top-4 z-10 border border-blue-100">
        <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center bg-blue-50">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $quiz->title }}</h2>
                <p class="text-sm text-gray-500">Total: {{ $quiz->questions->count() }} Pertanyaan</p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center bg-white px-4 py-2 rounded-lg shadow-sm border border-red-100">
                <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-mono text-xl font-bold text-red-600" id="countdown">--:--:--</span>
            </div>
        </div>
    </div>

    <form action="{{ route('mahasiswa.courses.quizzes.submit', ['course' => $course, 'quiz' => $quiz->id]) }}" method="POST" id="quizForm">
        @csrf
        
        <div class="space-y-8">
            @foreach($quiz->questions as $index => $question)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100" id="q_{{ $question->id }}">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="text-lg font-medium text-gray-900"><span class="mr-2 text-blue-600 font-bold">{{ $index + 1 }}.</span> {{ $question->question_text }}</h3>
                        <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2.5 py-0.5 rounded ml-4 whitespace-nowrap">{{ $question->points }} Poin</span>
                    </div>
                    
                    <div class="space-y-3 mt-4 ml-6">
                        @foreach($question->options as $option)
                            <label class="flex items-start p-3 rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-200 cursor-pointer transition-colors option-label">
                                <div class="flex items-center h-5">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="text-gray-700">{{ $option->option_text }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex justify-end">
            <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-bold shadow-lg transition-transform transform hover:-translate-y-0.5" onclick="return confirm('Apakah Anda yakin ingin menyelesaikan kuis ini? Pastikan semua soal telah terjawab.');">
                Selesai & Kumpulkan
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Styling selected options
    const radios = document.querySelectorAll('input[type="radio"]');
    
    function updateLabels() {
        document.querySelectorAll('.option-label').forEach(label => {
            label.classList.remove('bg-blue-50', 'border-blue-300', 'ring-1', 'ring-blue-300');
        });
        radios.forEach(radio => {
            if (radio.checked) {
                const label = radio.closest('.option-label');
                label.classList.add('bg-blue-50', 'border-blue-300', 'ring-1', 'ring-blue-300');
            }
        });
    }

    radios.forEach(radio => {
        radio.addEventListener('change', updateLabels);
    });
    updateLabels();

    // Countdown Timer logic
    const startTimeStr = "{{ $attempt->start_time->toIso8601String() }}";
    const timeLimitMinutes = {{ $quiz->time_limit_minutes }};
    
    // Calculate exact end time based on server start time + time limit
    const startTime = new Date(startTimeStr).getTime();
    const endTime = startTime + (timeLimitMinutes * 60 * 1000);
    
    const countdownEl = document.getElementById('countdown');
    const form = document.getElementById('quizForm');
    
    function updateTimer() {
        const now = new Date().getTime();
        const distance = endTime - now;
        
        if (distance <= 0) {
            clearInterval(timerInterval);
            countdownEl.innerHTML = "WAKTU HABIS";
            countdownEl.classList.remove('text-red-600');
            countdownEl.classList.add('text-red-800', 'animate-pulse');
            
            // Auto submit
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = "Mengumpulkan...";
            form.submit();
            return;
        }
        
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        let display = "";
        if (hours > 0) display += (hours < 10 ? "0" + hours : hours) + ":";
        display += (minutes < 10 ? "0" + minutes : minutes) + ":";
        display += (seconds < 10 ? "0" + seconds : seconds);
        
        countdownEl.innerHTML = display;

        if (distance < 5 * 60 * 1000) { // Less than 5 minutes
            countdownEl.parentElement.classList.add('bg-red-50', 'animate-pulse');
        }
    }
    
    updateTimer(); // Initial call
    const timerInterval = setInterval(updateTimer, 1000);
});
</script>
@endsection
