<?php

namespace App\Http\Controllers;

use App\Exam;
use App\MemoryGame;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if($user->hasRole('teacher')) {
            return view('pages.teacher-side.main.index');
        }
        else if ($user->hasRole('student')) {
            $subjects = Subject::all();
            $exams = Exam::all();
            return view('pages.student-side.index',['subjects' => $subjects,'exams'=>$exams]);
        }
    }

    public function images()
    {
        $images = MemoryGame::all();
        return view('pages.images', ['images'=>$images]);
    }

    public function edit()
    {
        return view('pages.teacher-side.main.change-password');
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect('/')->with('status','Player edited successfully');
    }

}
