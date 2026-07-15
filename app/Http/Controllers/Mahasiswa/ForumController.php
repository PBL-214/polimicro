<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\ForumDiscussion;
use App\Models\ForumReply;
use App\Models\Makul;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    private function getEnrolledCourse($courseId)
    {
        $user = Auth::user();
        $enrolled = $user->getEnrolledMatkul();
        $course = $enrolled->firstWhere('id', $courseId);
        if (!$course) abort(404, 'Mata kuliah tidak ditemukan.');
        return $course;
    }

    public function index($courseId)
    {
        $course = $this->getEnrolledCourse($courseId);
        $discussions = ForumDiscussion::where('makul_id', $courseId)
            ->with(['user', 'replies'])
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('mahasiswa.forum.index', compact('course', 'discussions'));
    }

    public function show($courseId, $discussionId)
    {
        $course = $this->getEnrolledCourse($courseId);
        $discussion = ForumDiscussion::with(['user', 'topLevelReplies.user', 'topLevelReplies.children.user'])
            ->findOrFail($discussionId);

        return view('mahasiswa.forum.show', compact('course', 'discussion'));
    }

    public function store(Request $request, $courseId)
    {
        $this->getEnrolledCourse($courseId);
        $request->validate([
            'title' => 'required|string|max:200',
            'body' => 'required|string|max:5000',
        ]);

        $discussion = ForumDiscussion::create([
            'makul_id' => $courseId,
            'user_id' => Auth::id(),
            'title' => $request->title,
            'body' => $request->body,
        ]);

        // Notify dosen
        $makul = Makul::find($courseId);
        if ($makul && $makul->dosen) {
            $makul->dosen->notify(new GeneralNotification([
                'title' => 'Diskusi Baru',
                'message' => Auth::user()->name . ' membuat diskusi: ' . $request->title,
                'icon' => 'fas fa-comments',
                'color' => 'bg-blue-100',
                'text_color' => 'text-blue-600',
                'url' => route('dosen.courses.forum.show', [$courseId, $discussion->id]),
            ]));
        }

        return redirect()->route('mahasiswa.courses.forum.show', [$courseId, $discussion->id])
            ->with('success', 'Diskusi berhasil dibuat!');
    }

    public function reply(Request $request, $courseId, $discussionId)
    {
        $this->getEnrolledCourse($courseId);
        $request->validate([
            'body' => 'required|string|max:5000',
            'parent_id' => 'nullable|exists:forum_replies,id',
        ]);

        ForumReply::create([
            'discussion_id' => $discussionId,
            'user_id' => Auth::id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim!');
    }
}
