<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Archieve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ArchieveController extends Controller
{
    public function index()
    {
        $archives = Archieve::latest()->get();
        return view('admin.pages.archive.archive',compact('archives'));
    }

    public function store(Request $request)
    {
        $imageFile = 'image/archivePhotos';
        if ($request->hasFile('photo')) {
            $image = $request->file('photo')->store($imageFile, 'public');
        }
        Archieve::create([
            'title_en' =>  $request->title_en,
            'title_bn' => $request->title_bn,
            'photo' => $image ?? null,
        ]);
        return redirect()->back()->with('success','Archive Added Successfully');
    }

    public function destroy($id)
    {
        try {
            $archive = Archieve::findOrFail($id);
            $archive->delete();
            Alert::success('Success', 'Archive deleted successfully');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while deleting the Archive');
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
