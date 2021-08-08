<?php

namespace App\Http\Controllers;

use App\Group;
use App\Imports\StudentsImport;
use App\Student;
use http\Exception;
use Illuminate\Http\Request;
use Excel;


class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $groups = Group::all();

        return view('pages.teacher-side.classes.index',['groups'=>$groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        $students = Student::all();

        return view('pages.teacher-side.classes.show', ['group'=>$group,'students'=>$students]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return redirect('classes')->with('status','All classes deleted successfully');
    }
    public function indexImport()
    {
        return view('pages.teacher-side.classes.import');
    }
    public function import(Request $request)
    {
        \DB::beginTransaction();
        try {
            $group = new Group();
            $group->name = $request->class_name;
            $group->save();
            Excel::import(new StudentsImport(), $request->file('select_file'));
            \DB::commit();
            return redirect('/')->with('success', 'All good');
        }catch (Exception $exception) {
            \DB::rollback();
            return redirect('/')->with('status', 'Exercise failed');
        }


}
    //JSON
    public function countClasses(){
        $classes = Group::all();
        $number = count($classes);
        return response()->json($number,200);
    }
}
