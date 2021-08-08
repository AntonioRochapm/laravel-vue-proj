<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\MemoryGame;
use App\Question;
use App\Subject;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.teacher-side.exercises.list-exercises');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = Subject::all();
        $types = Type::all();

        return view('pages.teacher-side.exercises.create-exercise',['subjects'=>$subjects,'types'=>$types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function show(Exercise $exercise)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function edit(Exercise $exercise)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exercise $exercise)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function destroy(Exercise $exercise)
    {

    }

    //  Json section

    public function subjectJson()
    {
        $subjects = Subject::all();
        return response()->json($subjects,200);
    }

    public function typeJson()
    {
        $types = Type::all();
        return response()->json($types,200);
    }

    public function exerciseJson()
    {
        $exercises = Exercise::all();
        return response()->json($exercises,200);
    }
    public function countExercises(){
        $exercises = Exercise::all();
        $number = count($exercises);
        return response()->json($number,200);
    }
}
