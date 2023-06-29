<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WebsiteController extends Controller
{
    //View HTML Website
    public function website()
    {
        $filePath = public_path('website');
        dd($filePath);
        if (File::exists($filePath)) {
            return response()->file($filePath);
        } else {
            abort(404, 'File not found');
        }
    }
}
