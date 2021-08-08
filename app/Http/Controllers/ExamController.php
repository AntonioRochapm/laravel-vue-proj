<?php

namespace App\Http\Controllers;

use App\Exam;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam = Exam::all();
        return response()->json($exam,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.teacher-side.exam.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        \DB::beginTransaction();
        try{
            $exam = new Exam();

            $exam->exam_type = 1;

            $exam->name = $request[1];
            $exam->teacher_id = Auth::user()->userable_id;

            $exam->save();

            $exam->exercises()->sync($request[0]);

            \DB::commit();

            return response()->json(['status' => 'Exam created successfully']);

        }catch(\Exception $exception){

            \DB::rollback();

            return response()->json(['error' => $exception]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        //
    }

    public function listExams()
    {
        $exams = Exam::all();

        foreach ($exams as $exam){
            $exam->teacher_id = User::find($exam->teacher_id)->name;
        }
        return view('pages.teacher-side.exam.list-exams',['exams'=>$exams]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try{

            $examToBeDeleted = Exam::find($id)->first();

            $examToBeDeleted->exercises()->detach();
            $examToBeDeleted->delete();

            return redirect('exam/list')->with('status','Item deleted successfully!');

        }catch(Exception $exception){

            return redirect('exams/list')->with('status','error');
        }
    }
    //JSON
    public function countExams(){
        $exams = Exam::all();
        $number = count($exams);
        return response()->json($number,200);
    }

    //JSON
    public function getExamsExercises($id){

        //Here we want to see if an exercise exists in a exam and return a boolean
        $isRelated = DB::table('exam_exercise')->where('exercise_id', $id)->exists();

        return response()->json($isRelated,200);
    }
}
