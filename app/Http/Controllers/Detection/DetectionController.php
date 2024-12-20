<?php

namespace App\Http\Controllers\Detection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetectionController extends Controller
{
    public function create()
    {
        return view('detections.create');
    }
}
