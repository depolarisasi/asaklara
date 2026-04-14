<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Inertia\Inertia;

class ContactSubmissionController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Submissions/Index', [
            'submissions' => ContactSubmission::latest()->get(),
            'unread_count' => ContactSubmission::unread()->count(),
        ]);
    }

    public function show(ContactSubmission $submission)
    {
        if (!$submission->is_read) {
            $submission->update(['is_read' => true]);
        }

        return Inertia::render('Admin/Submissions/Show', [
            'submission' => $submission,
        ]);
    }

    public function markRead(ContactSubmission $submission)
    {
        $submission->update(['is_read' => true]);
        return back()->with('success', 'Pesan ditandai sebagai sudah dibaca.');
    }

    public function destroy(ContactSubmission $submission)
    {
        $submission->delete();
        return redirect()->route('admin.submissions.index')->with('success', 'Pesan berhasil dihapus!');
    }
}
