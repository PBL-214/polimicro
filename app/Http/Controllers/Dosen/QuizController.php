<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Makul;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::whereHas('makul', function ($query) {
            $query->where('dosen_id', auth()->id());
        })->with(['makul', 'materi'])->latest()->get();

        return view('dosen.quizzes.index', compact('quizzes'));
    }

    public function create(Request $request)
    {
        $makuls = Makul::where('dosen_id', auth()->id())->get();
        $selectedMakulId = $request->query('makul_id');
        $selectedMakul = null;
        $materials = [];
        if ($selectedMakulId) {
            $selectedMakul = Makul::where('id', $selectedMakulId)->where('dosen_id', auth()->id())->first();
            if ($selectedMakul) {
                $materials = \App\Models\Materi::where('makul_id', $selectedMakulId)->get();
            }
        }
        return view('dosen.quizzes.create', compact('makuls', 'selectedMakulId', 'selectedMakul', 'materials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'makul_id' => 'required|exists:makul,id',
            'materi_id' => 'nullable|exists:materi,id',
            'time_limit_minutes' => 'required|integer|min:1',
            'status' => 'required|in:draft,published',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.option_text' => 'required|string',
            'questions.*.options.*.is_correct' => 'nullable|boolean',
        ]);

        $quiz = Quiz::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'makul_id' => $validated['makul_id'],
            'materi_id' => $validated['materi_id'] ?? null,
            'time_limit_minutes' => $validated['time_limit_minutes'],
            'status' => $validated['status'],
        ]);

        foreach ($validated['questions'] as $qData) {
            $question = $quiz->questions()->create([
                'question_text' => $qData['question_text'],
                'points' => $qData['points'] ?? 1,
            ]);

            foreach ($qData['options'] as $index => $optData) {
                $isCorrect = isset($optData['is_correct']) && $optData['is_correct'] == '1' ? true : false;
                
                $question->options()->create([
                    'option_text' => $optData['option_text'],
                    'is_correct' => $isCorrect,
                ]);
            }
        }

        return redirect()->route('dosen.courses.show', $quiz->makul_id)->with('success', 'Kuis berhasil dibuat.');
    }

    public function show(Quiz $quiz)
    {
        if ($quiz->makul->dosen_id !== auth()->id()) abort(403);
        $quiz->load(['questions.options', 'attempts.user']);
        return view('dosen.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        if ($quiz->makul->dosen_id !== auth()->id()) abort(403);
        $makuls = Makul::where('dosen_id', auth()->id())->get();
        $materials = \App\Models\Materi::where('makul_id', $quiz->makul_id)->get();
        $quiz->load(['questions.options']);
        return view('dosen.quizzes.edit', compact('quiz', 'makuls', 'materials'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        if ($quiz->makul->dosen_id !== auth()->id()) abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'makul_id' => 'required|exists:makul,id',
            'materi_id' => 'nullable|exists:materi,id',
            'time_limit_minutes' => 'required|integer|min:1',
            'status' => 'required|in:draft,published',
            'questions' => 'required|array|min:1',
            'questions.*.id' => 'nullable|exists:quiz_questions,id',
            'questions.*.question_text' => 'required|string',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.id' => 'nullable|exists:quiz_options,id',
            'questions.*.options.*.option_text' => 'required|string',
            'questions.*.options.*.is_correct' => 'nullable|boolean',
        ]);

        $quiz->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'makul_id' => $validated['makul_id'],
            'materi_id' => $validated['materi_id'] ?? null,
            'time_limit_minutes' => $validated['time_limit_minutes'],
            'status' => $validated['status'],
        ]);

        $questionIds = collect($validated['questions'])->pluck('id')->filter()->all();
        $quiz->questions()->whereNotIn('id', $questionIds)->delete();

        foreach ($validated['questions'] as $qData) {
            $question = $quiz->questions()->updateOrCreate(
                ['id' => $qData['id'] ?? null],
                [
                    'question_text' => $qData['question_text'],
                    'points' => $qData['points'] ?? 1,
                ]
            );

            $optionIds = collect($qData['options'])->pluck('id')->filter()->all();
            $question->options()->whereNotIn('id', $optionIds)->delete();

            foreach ($qData['options'] as $optData) {
                $isCorrect = isset($optData['is_correct']) && $optData['is_correct'] == '1' ? true : false;
                $question->options()->updateOrCreate(
                    ['id' => $optData['id'] ?? null],
                    [
                        'option_text' => $optData['option_text'],
                        'is_correct' => $isCorrect,
                    ]
                );
            }
        }

        return redirect()->route('dosen.courses.show', $quiz->makul_id)->with('success', 'Kuis berhasil diperbarui.');
    }

    public function destroy(Quiz $quiz)
    {
        if ($quiz->makul->dosen_id !== auth()->id()) abort(403);
        $makul_id = $quiz->makul_id;
        $quiz->delete();
        return redirect()->route('dosen.courses.show', $makul_id)->with('success', 'Kuis berhasil dihapus.');
    }
}
