<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\EngChapter;
use App\Models\EnglishAudio;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class EnglishAudioController extends Controller
{
    public function index()
    {
        $chapters = EngChapter::where('book_id',2)->get();
        $englishAudio = EnglishAudio::with('chapter')->latest()->get();
        return view('admin.pages.audio.audio_english',compact('englishAudio','chapters'));
    }

    public function store(Request $request)
    {
        $audioFile = 'audio/audioEnglishFile';
        if ($request->hasFile('file')) {
            $uploadedFile = $request->file('file');
            $originalFileName = $uploadedFile->getClientOriginalName();
            $storedFileName = $uploadedFile->storeAs($audioFile, $originalFileName, 'public');
        }
        EnglishAudio::create([
            'chapter_id' => $request->chapter_id,
            'file' => $originalFileName ?? null,
        ]);
        return redirect()->back()->with('success','Audio Added Successfully');
    }

    public function destroy($id)
    {
        try {
            $audioFile = EnglishAudio::findOrFail($id);
            $audioFile->delete();
            EnglishAudio::success('Success', 'Audio deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while deleting the Archive');
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
