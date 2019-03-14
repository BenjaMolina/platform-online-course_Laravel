<?php

namespace App\Http\Controllers;

use App\User;
use App\Course;
use App\Student;
use Illuminate\Http\Request;
use App\Mail\MessageToStudent;

class TeacherController extends Controller
{
    public function courses(){
        $courses = Course::withCount(['students'])
                            ->with('category','reviews')
                            ->whereTeacherId(auth()->user()->teacher->id)
                            ->paginate(12);
                            

        return view('teachers.courses',compact('courses'));
    }

    public function students()
    {
        $students = Student::with('user', 'courses.reviews')
            ->whereHas('courses', function ($q) {
                $q->where('teacher_id', auth()->user()->teacher->id)->select('id', 'teacher_id', 'name')->withTrashed();
            })->get();

        $actions = 'students.datatables.actions'; //plantilla Blade

        return \DataTables::of($students)
            ->addColumn('actions', $actions)
            ->rawColumns(['actions', 'courses_formatted']) //Mostrar columnas como HTML
            ->make(true);
    }

    public function sendMessageToStudent(Request $request)
    {

        $info = $request->info;
        $data = [];
        parse_str($info, $data);

        $user = User::findOrFail($data['user_id']);

        $succes = true;

        try {
            \Mail::to($user)
                ->send(new MessageToStudent(auth()->user()->name, $data['message']));
        } catch (\Exception $exception) {
            $succes = false;
        }

        return response()->json(['res' => $succes]);
    }
}
