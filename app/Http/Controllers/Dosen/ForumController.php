<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\ForumDiscussion;
use App\Models\ForumReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    private function getDosenCourse($courseId)
    {
        $course = Auth::user()->matkulDiampu()->findOrFail($courseId);
        return $course;
    }

    public function index($courseId)
    {
        $course = $this->getDosenCourse($courseId);
        $discussions = ForumDiscussion::where('makul_id', $courseId)
            ->with(['user', 'replies'])
            ->orderByDesc('is_pinned')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('dosen.forum.index', compact('course', 'discussions'));
    }

    public function show($courseId, $discussionId)
    {
        $course = $this->getDosenCourse($courseId);
        $discussion = ForumDiscussion::with(['user', 'topLevelReplies.user', 'topLevelReplies.children.user'])
            ->findOrFail($discussionId);

        return view('dosen.forum.show', compact('course', 'discussion'));
    }

    public function reply(Request $request, $courseId, $discussionId)
    {
        $this->getDosenCourse($courseId);
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

    public function togglePin($courseId, $discussionId)
    {
        $this->getDosenCourse($courseId);
        $discussion = ForumDiscussion::findOrFail($discussionId);
        $discussion->update(['is_pinned' => !$discussion->is_pinned]);

        return back()->with('success', $discussion->is_pinned ? 'Diskusi berhasil di-pin!' : 'Pin diskusi dihapus!');
    }

    public function destroy($courseId, $discussionId)
    {
        $this->getDosenCourse($courseId);
        ForumDiscussion::findOrFail($discussionId)->delete();

        return redirect()->route('dosen.courses.forum.index', $courseId)
            ->with('success', 'Diskusi berhasil dihapus!');
    }
}
