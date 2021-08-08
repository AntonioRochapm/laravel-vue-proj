<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\Group;
use App\Imports\BooksImport;
use App\Role;
use App\Student;
use App\Subject;
use App\Type;
use App\User;
use http\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $subjects = Subject::all();
        return view('pages.student-side.index', ['subjects'=>$subjects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classes = Group::all();
        return view('pages.teacher-side.student.create',['classes'=>$classes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $student = new Student();
            $student->student_number = $request->student_number;
            $student->group_id = $request->group_id;
            $student->save();
            $student->user()->create([
                'name' => $request->name,
                'email' => $request->email,
                'picture_url' => "none",
                'state' => 1,
                'password' =>Hash::make($request->password)
            ]);

            $s = Role::where('slug','student')->first();
            $u = User::where('userable_id',$student->id)->first();
            $u->roles()->attach($s);

            \DB::commit();
        }catch (Exception $exception) {
            \DB::rollback();
            return redirect('teacher-side')->with('status', 'Exercise failed');
        }



        return redirect('/')->with('status','Student created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $groups = Group::all();

        return view('pages.teacher-side.student.edit',['student'=>$student,'groups'=>$groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {

        $student->user->update($request->all());

        return redirect('classes/' . $student->group_id)->with('status','Player edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        try{
            $group=$student->group_id;
            $user = User::where('userable_id', '=', $student->id)->firstOrFail();
            $user->delete();
            $student->delete();
        }catch(Throwable $e){
            return redirect('classes/'.$group)->with('Status','Something went wrong, try again');
        }
        return redirect('classes/'.$group)->with('Status','Success!');
    }


    public function reset_password(Student $student)
    {
        $student->user->password = Hash::make('colegionovomaia');
        $student->user->save();

        return redirect('/students/' . $student->id . '/edit')->with('status','Password reseted successfully');
    }
    public function selectType($subject)
    {
        $types= Type::all();
        return view('pages.student-side.student-select-exercise-type', ['subject'=>$subject, 'types'=>$types]);
    }
    public function listExercise($subject, $type)
    {
        $exercises= Exercise::where('subject_id', $subject)->where('type_id', $type)->get();
        return view('pages.student-side.exercise-list', ['exercises'=>$exercises]);
    }
    //JSON
    public function countStudents(){
        $students = User::where('userable_type', 'App\Student')->get();
        $number = count($students);
        return response()->json($number,200);
    }
}
