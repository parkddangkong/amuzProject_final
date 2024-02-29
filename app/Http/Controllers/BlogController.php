<?php

namespace App\Http\Controllers;
use App\Models\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function door()
    {
        return view('blog');
    }
}
