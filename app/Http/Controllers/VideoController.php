<?php

namespace App\Http\Controllers;

use App\Models\DashboardVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $videos = DashboardVideo::where(function ($query) {
            $query->where('is_public', true)
                ->orWhere('user_id', Auth::id());
        })
            ->oldest()
            ->get();

        return view('menu.video', compact('videos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'youtube_url' => 'required|url',
            'is_public' => 'nullable|boolean',
        ]);

        DashboardVideo::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'youtube_url' => $request->youtube_url,
            'is_public'   => $request->boolean('is_public'),
        ]);

        return redirect()
            ->route('video.index')
            ->with('success', 'Video berhasil ditambahkan.');
    }

    public function update(Request $request, DashboardVideo $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'youtube_url' => 'required|url',
            'is_public' => 'nullable|boolean',
        ]);

        $video->update([
            'title'       => $request->title,
            'youtube_url' => $request->youtube_url,
            'is_public'   => $request->boolean('is_public'),
        ]);

        return redirect()
            ->route('video.index')
            ->with('success', 'Video berhasil diperbarui.');
    }

    public function destroy(DashboardVideo $video)
    {
        if ($video->user_id !== Auth::id()) {
            abort(403);
        }

        $video->delete();

        return redirect()
            ->route('video.index')
            ->with('success', 'Video berhasil dihapus.');
    }
}
