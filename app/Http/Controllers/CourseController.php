<?php

namespace App\Http\Controllers;

use App\Course;

// use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show(Course $course)  {
        dd($course);
    }
}
