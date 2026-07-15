<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use Illuminate\Http\Request;

class QuizController extends Controller
{


    public function take($course, Quiz $quiz)
    {
        $studentId = auth()->id();
        $user = auth()->user();

        // Check if student is enrolled
        $enrolledMatkulIds = $user->getEnrolledMatkul()->pluck('id')->toArray();
        $isEnrolled = in_array($quiz->makul_id, $enrolledMatkulIds);
        
        if (!$isEnrolled || $quiz->status !== 'published') {
            abort(403);
        }

        // Check if attempt exists
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $studentId)
            ->first();
            
        if ($attempt && $attempt->end_time) {
            // Already finished
            return redirect()->route('mahasiswa.courses.quizzes.result', ['course' => $course, 'attempt' => $attempt->id]);
        }

        if (!$attempt) {
            return view('mahasiswa.quizzes.start', compact('course', 'quiz'));
        }

        // Quiz in progress
        $quiz->load(['questions.options']);
        return view('mahasiswa.quizzes.take', compact('course', 'quiz', 'attempt'));
    }

    public function start($course, Quiz $quiz)
    {
        $studentId = auth()->id();
        
        // Prevent multiple attempts
        $existing = QuizAttempt::where('quiz_id', $quiz->id)->where('user_id', $studentId)->first();
        if ($existing) {
            return redirect()->route('mahasiswa.courses.quizzes.take', ['course' => $course, 'quiz' => $quiz->id]);
        }

        $attempt = QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'user_id' => $studentId,
            'start_time' => now(),
        ]);

        return redirect()->route('mahasiswa.courses.quizzes.take', ['course' => $course, 'quiz' => $quiz->id]);
    }

    public function submit(Request $request, $course, Quiz $quiz)
    {
        $studentId = auth()->id();
        
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', $studentId)
            ->whereNull('end_time')
            ->firstOrFail();

        $answers = $request->input('answers', []);
        
        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($quiz->questions as $question) {
            $totalPoints += $question->points;
            
            $selectedOptionId = $answers[$question->id] ?? null;
            
            if ($selectedOptionId) {
                $option = $question->options()->find($selectedOptionId);
                if ($option && $option->is_correct) {
                    $earnedPoints += $question->points;
                }
            }

            QuizAttemptAnswer::create([
                'quiz_attempt_id' => $attempt->id,
                'quiz_question_id' => $question->id,
                'quiz_option_id' => $selectedOptionId,
            ]);
        }

        $score = $totalPoints > 0 ? ($earnedPoints / $totalPoints) * 100 : 0;

        $attempt->update([
            'end_time' => now(),
            'score' => $score,
        ]);

        return redirect()->route('mahasiswa.courses.quizzes.result', ['course' => $course, 'attempt' => $attempt->id])->with('success', 'Kuis berhasil diselesaikan!');
    }

    public function result($course, QuizAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) abort(403);
        
        $attempt->load(['quiz.questions.options', 'answers']);
        return view('mahasiswa.quizzes.result', compact('course', 'attempt'));
    }
}
