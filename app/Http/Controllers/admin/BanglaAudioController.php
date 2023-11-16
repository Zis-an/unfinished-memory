<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BanglaAudio;
use App\Models\Chapter;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BanglaAudioController extends Controller
{
    public function index()
    {
        $chapters = Chapter::where('book_id',1)->get();
        $banglaAudio = BanglaAudio::with('chapter')->latest()->get();
        return view('admin.pages.audio.audio_bangla',compact('banglaAudio','chapters'));
    }

    public function store(Request $request)
    {
        $audioFile = 'audio/audioBanglaFile';
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $originalFileName = $uploadedFile->getClientOriginalName();
            $storedFileName = $uploadedFile->storeAs($audioFile, $originalFileName, 'public');
        }
        BanglaAudio::create([
            'chapter_id' => $request->chapter_id,
            'file' => $originalFileName ?? null,
        ]);
        return redirect()->back()->with('success','Audio Added Successfully');
    }

    public function destroy($id)
    {
        try {
            $audioFile = BanglaAudio::findOrFail($id);
            $audioFile->delete();
            BanglaAudio::success('Success', 'Audio deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while deleting the Archive');
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
