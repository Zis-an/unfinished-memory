<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Archieve;
use Illuminate\Http\Request;

class ArchieveController extends Controller
{
    public function index()
    {
        $archives = Archieve::latest()->get();
        return response()->json([
            'allPhoto' => $archives
        ]);
    }
}
