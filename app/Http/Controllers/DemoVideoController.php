<?php

namespace App\Http\Controllers;

use App\Models\DemoVideo;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DemoVideoController extends Controller
{
    /**
     * Display a listing of the demo videos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $videos = DemoVideo::orderBy('created_at', 'desc')->get();
        return view('admin.demo.index', compact('videos'));
    }

    /**
     * Show the form for creating a new demo video.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subjects = Course::with('category')->get(); // Assuming Course has a relationship with Category
        return view('admin.demo.create', compact('subjects'));
    }

    /**
     * Store a newly created demo video in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'subject_id' => 'nullable|exists:courses,id',
            'thumbnail' => 'required',
            'duration' => 'required|max:10',
            'instructor' => 'required|max:100',
            'video_url' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DemoVideo::create([
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'thumbnail' => $request->thumbnail,
            'duration' => $request->duration,
            'instructor' => $request->instructor,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.demo_videos.index')
            ->with('success', get_phrase('Demo video has been added successfully'));
    }

    /**
     * Show the form for editing the specified demo video.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $video = DemoVideo::findOrFail($id);
        $subjects = Course::all(); // Assuming you have a Subject model
        return view('admin.demo.edit', compact('video', 'subjects'));
    }

    /**
     * Update the specified demo video in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'subject_id' => 'nullable|exists:courses,id',
            'thumbnail' => 'required',
            'duration' => 'required|max:10',
            'instructor' => 'required|max:100',
            'video_url' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $video = DemoVideo::findOrFail($id);
        $video->update([
            'title' => $request->title,
            'subject_id' => $request->subject_id,
            'thumbnail' => $request->thumbnail,
            'duration' => $request->duration,
            'instructor' => $request->instructor,
            'video_url' => $request->video_url,
        ]);

        return redirect()->route('admin.demo_videos.index')
            ->with('success', get_phrase('Demo video has been updated successfully'));
    }

    /**
     * Remove the specified demo video from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $video = DemoVideo::findOrFail($id);

        // Delete the thumbnail and video files if they exist
        if (file_exists(public_path($video->thumbnail))) {
            File::delete(public_path($video->thumbnail));
        }

        if (file_exists(public_path($video->video_url))) {
            File::delete(public_path($video->video_url));
        }

        $video->delete();

        return redirect()->route('admin.demo_videos.index')
            ->with('success', get_phrase('Demo video has been deleted successfully'));
    }

    /**
     * Upload a video file with progress tracking.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadVideo(Request $request)
    {
        if (!$request->hasFile('video_file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $item = $request->file('video_file');
        $file_name = time() . random_int(1000, 9999) . '.' . $item->getClientOriginalExtension();
        $path = public_path('uploads/demo_videos/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $item-> move($path, $file_name);
        $relative_path = 'uploads/demo_videos/' . $file_name;

        return response()->json([
            'success' => true,
            'file_path' => $relative_path,
            'file_name' => $file_name
        ]);
    }

    /**
     * Upload a thumbnail image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadThumbnail(Request $request)
    {
        if (!$request->hasFile('thumbnail_file')) {
            return response()->json(['error' => 'No file uploaded'], 400);
        }

        $item = $request->file('thumbnail_file');
        $file_name = time() . random_int(1000, 9999) . '.' . $item->getClientOriginalExtension();
        $path = public_path('uploads/demo_videos/thumbnails/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $item->move($path, $file_name);
        $relative_path = 'uploads/demo_videos/thumbnails/' . $file_name;

        return response()->json([
            'success' => true,
            'file_path' => $relative_path,
            'file_name' => $file_name
        ]);
    }
}
