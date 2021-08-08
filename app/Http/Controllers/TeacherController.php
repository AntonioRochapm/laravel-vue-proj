<?php

namespace App\Http\Controllers;

use App\Role;
use App\Student;
use App\Teacher;
use App\User;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function teachersList()
    {
        $user = Auth::user();

        if (!$user->hasRole('administrator'))
            return redirect('/');

        $teachers = Teacher::all();

        return view('pages.teacher-side.teacher.teacher-list', ['teachers'=>$teachers]);
    }

    public function index()
    {
        return view('pages.teacher-side.exercises.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function memoryGame() {


        return view('pages.teacher.create-memory-game');

    }
    public function create()
    {
        $user = Auth::user();

        if (!$user->hasRole('administrator'))
            return redirect('/');

        return view('pages.teacher-side.teacher.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $teacher = new Teacher();
            $teacher->is_admin = $request->is_admin;
            $teacher->save();
            $teacher->user()->create([
                'name' => $request->name,
                'email' => $request->email,
                'picture_url' => "none",
                'state' => 1,
                'password' => Hash::make($request->password)
            ]);

            $t = Role::where('slug','teacher')->first();
            $s = Role::where('slug','student')->first();
            $u = User::where('userable_id',$teacher->id)->first();
            $u->roles()->attach($t);
            $u->roles()->attach($s);

            if($request->is_admin){
                $a = Role::where('slug','administrator')->first();
                $u->roles()->attach($a);
            }

            \DB::commit();
            return redirect('teacher-side/teachers-list')->with('status','Teacher created successfully');
        }catch (Exception $exception) {
            \DB::rollback();
            return redirect('teacher-side/teachers-list')->with('status', 'Exercise failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Teacher $teacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Teacher  $teacher
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function destroy(Teacher $teacher)
    {
        try{
            $user = User::where('userable_id', '=', $teacher->id)->firstOrFail();
            $user->delete();
            $teacher->delete();
        }catch(Throwable $e){
            return redirect('teacher-side/teachers-list')->with('Status','Something went wrong, try again');
        }
        return redirect('teacher-side/teachers-list')->with('Status','Success!');
    }
    //Json
    public function getTeacher()
    {
        $teachers = User::where('userable_type', 'App\Teacher')->get();

        return response()->json($teachers, 200);
    }
}
