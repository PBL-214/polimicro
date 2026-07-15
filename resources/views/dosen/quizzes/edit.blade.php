@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Edit Kuis</h1>
        <a href="{{ route('dosen.courses.show', $quiz->makul_id) }}" class="text-gray-500 hover:text-gray-700">&larr; Kembali ke Kelas</a>
    </div>

    <form action="{{ route('dosen.quizzes.update', $quiz) }}" method="POST" id="quizForm" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Informasi Dasar Kuis -->
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Informasi Kuis</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul Kuis</label>
                    <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Mata Kuliah</label>
                    <select name="makul_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Pilih Mata Kuliah</option>
                        @foreach($makuls as $makul)
                            <option value="{{ $makul->id }}" {{ $quiz->makul_id == $makul->id ? 'selected' : '' }}>{{ $makul->nama_makul }}</option>
                        @endforeach
                    </select>
                    @error('makul_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pilih Pertemuan (Materi) - Opsional</label>
                    <select name="materi_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">-- Tidak Terhubung ke Materi --</option>
                        @if(isset($materials))
                            @foreach($materials as $index => $mat)
                                <option value="{{ $mat->id }}" {{ (old('materi_id', $quiz->materi_id) == $mat->id) ? 'selected' : '' }}>Pertemuan {{ $index + 1 }}: {{ $mat->nama_materi }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('materi_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $quiz->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Durasi Waktu (Menit)</label>
                    <input type="number" name="time_limit_minutes" value="{{ old('time_limit_minutes', $quiz->time_limit_minutes) }}" required min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="draft" {{ $quiz->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $quiz->status == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Daftar Pertanyaan -->
        <div class="bg-white p-6 rounded-xl shadow">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-xl font-semibold text-gray-800">Pertanyaan</h2>
                <button type="button" id="addQuestionBtn" class="bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1 rounded text-sm font-medium">
                    + Tambah Pertanyaan
                </button>
            </div>

            <div id="questionsContainer" class="space-y-6">
                <!-- Template Pertanyaan akan ditambahkan ke sini oleh JS, atau di-render via PHP jika ada -->
                @foreach($quiz->questions as $qIndex => $question)
                <div class="question-item border border-gray-200 p-4 rounded-lg bg-gray-50 relative">
                    <input type="hidden" name="questions[{{ $qIndex }}][id]" value="{{ $question->id }}">
                    <button type="button" class="remove-question absolute top-4 right-4 text-red-500 hover:text-red-700 font-medium text-sm">Hapus Soal</button>
                    
                    <div class="mb-4 pr-20">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan <span class="q-number">{{ $loop->iteration }}</span></label>
                        <textarea name="questions[{{ $qIndex }}][question_text]" required rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $question->question_text }}</textarea>
                    </div>
                    
                    <div class="mb-4 w-32">
                        <label class="block text-xs font-medium text-gray-700 mb-1">Poin / Bobot Nilai</label>
                        <input type="number" name="questions[{{ $qIndex }}][points]" value="{{ $question->points }}" required min="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                    </div>

                    <div class="options-container space-y-2 mt-4 pl-4 border-l-2 border-gray-300" data-qid="{{ $qIndex }}">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Jawaban (Pilih jawaban yang benar)</label>
                        @foreach($question->options as $oIndex => $option)
                        <div class="flex items-center space-x-2 option-item">
                            <input type="hidden" name="questions[{{ $qIndex }}][options][{{ $oIndex }}][id]" value="{{ $option->id }}">
                            <input type="radio" name="questions[{{ $qIndex }}][correct_option]" value="{{ $oIndex }}" class="correct-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer" required {{ $option->is_correct ? 'checked' : '' }}>
                            <input type="hidden" name="questions[{{ $qIndex }}][options][{{ $oIndex }}][is_correct]" value="{{ $option->is_correct ? '1' : '0' }}" class="is-correct-hidden">
                            <input type="text" name="questions[{{ $qIndex }}][options][{{ $oIndex }}][option_text]" value="{{ $option->option_text }}" required placeholder="Teks pilihan..." class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <button type="button" class="remove-option text-red-500 hover:text-red-700 px-2">&times;</button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="add-option mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center" data-qid="{{ $qIndex }}">
                        + Tambah Pilihan
                    </button>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold shadow-lg transition-transform transform hover:-translate-y-0.5">
                Perbarui Kuis
            </button>
        </div>
    </form>
</div>

<!-- Template HTML untuk JS -->
<template id="questionTemplate">
    <div class="question-item border border-gray-200 p-4 rounded-lg bg-gray-50 relative">
        <button type="button" class="remove-question absolute top-4 right-4 text-red-500 hover:text-red-700 font-medium text-sm">Hapus Soal</button>
        
        <div class="mb-4 pr-20">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan <span class="q-number"></span></label>
            <textarea name="questions[__QID__][question_text]" required rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
        </div>
        
        <div class="mb-4 w-32">
            <label class="block text-xs font-medium text-gray-700 mb-1">Poin / Bobot Nilai</label>
            <input type="number" name="questions[__QID__][points]" value="10" required min="1" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
        </div>

        <div class="options-container space-y-2 mt-4 pl-4 border-l-2 border-gray-300" data-qid="__QID__">
            <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Jawaban (Pilih jawaban yang benar)</label>
            <!-- Options akan masuk sini -->
        </div>
        <button type="button" class="add-option mt-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium flex items-center" data-qid="__QID__">
            + Tambah Pilihan
        </button>
    </div>
</template>

<template id="optionTemplate">
    <div class="flex items-center space-x-2 option-item">
        <input type="radio" name="questions[__QID__][correct_option]" value="__OID__" class="correct-radio h-4 w-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer" required>
        <input type="hidden" name="questions[__QID__][options][__OID__][is_correct]" value="0" class="is-correct-hidden">
        <input type="text" name="questions[__QID__][options][__OID__][option_text]" required placeholder="Teks pilihan..." class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
        <button type="button" class="remove-option text-red-500 hover:text-red-700 px-2">&times;</button>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('questionsContainer');
    const qTemplate = document.getElementById('questionTemplate').innerHTML;
    const oTemplate = document.getElementById('optionTemplate').innerHTML;
    
    // Set counter above existing questions
    let qCounter = {{ max(count($quiz->questions), 0) }} + 1000;
    
    function addQuestion() {
        const qId = qCounter++;
        let html = qTemplate.replace(/__QID__/g, qId);
        
        const div = document.createElement('div');
        div.innerHTML = html;
        const qNode = div.firstElementChild;
        
        container.appendChild(qNode);
        updateQuestionNumbers();
        
        // Add 2 default options
        addOption(qNode, qId);
        addOption(qNode, qId);
        
        setupQuestionEvents(qNode);
    }
    
    function setupQuestionEvents(qNode) {
        qNode.querySelector('.remove-question').addEventListener('click', function() {
            qNode.remove();
            updateQuestionNumbers();
        });
        
        const addBtn = qNode.querySelector('.add-option');
        const qId = addBtn.getAttribute('data-qid');
        
        addBtn.addEventListener('click', function() {
            addOption(qNode, qId);
        });

        const optionsContainer = qNode.querySelector('.options-container');
        optionsContainer.querySelectorAll('.option-item').forEach(oNode => setupOptionEvents(qNode, oNode));
    }

    function addOption(qNode, qId) {
        const oContainer = qNode.querySelector('.options-container');
        const oId = Date.now() + Math.floor(Math.random() * 10000); 
        
        let html = oTemplate
            .replace(/__QID__/g, qId)
            .replace(/__OID__/g, oId);
            
        const div = document.createElement('div');
        div.innerHTML = html;
        const oNode = div.firstElementChild;
        
        oContainer.appendChild(oNode);
        setupOptionEvents(qNode, oNode);
    }

    function setupOptionEvents(qNode, oNode) {
        const oContainer = qNode.querySelector('.options-container');
        
        oNode.querySelector('.remove-option').addEventListener('click', function() {
            if (oContainer.querySelectorAll('.option-item').length > 2) {
                oNode.remove();
            } else {
                alert('Minimal harus ada 2 pilihan jawaban.');
            }
        });

        oNode.querySelector('.correct-radio').addEventListener('change', function() {
            const hiddens = qNode.querySelectorAll('.is-correct-hidden');
            hiddens.forEach(h => h.value = "0");
            oNode.querySelector('.is-correct-hidden').value = "1";
        });
    }
    
    function updateQuestionNumbers() {
        const questions = container.querySelectorAll('.question-item');
        questions.forEach((q, index) => {
            q.querySelector('.q-number').textContent = (index + 1);
        });
    }
    
    document.getElementById('addQuestionBtn').addEventListener('click', addQuestion);

    // Setup existing items
    document.querySelectorAll('.question-item').forEach(qNode => {
        setupQuestionEvents(qNode);
    });

    document.getElementById('quizForm').addEventListener('submit', function(e) {
        const questions = container.querySelectorAll('.question-item');
        if (questions.length === 0) {
            e.preventDefault();
            alert('Silakan tambahkan setidaknya satu pertanyaan.');
            return;
        }

        let valid = true;
        questions.forEach((q, index) => {
            const checkedRadio = q.querySelector('.correct-radio:checked');
            if (!checkedRadio) {
                valid = false;
                alert('Silakan pilih jawaban yang benar untuk Pertanyaan ' + (index + 1));
            }
        });

        if (!valid) e.preventDefault();
    });
});
</script>
@endsection
