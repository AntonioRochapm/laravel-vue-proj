<?php

namespace App\Http\Controllers;

use App\CorrectAnswer;
use App\DragDrop;
use App\Exercise;
use App\Question;
use App\Subject;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Illuminate\Support\Facades\DB;

class DragDropController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subject)
    {
        return view('pages.teacher-side.exercises.create-drag-and-drop',['subject' => $subject]);
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
            $data = json_decode($request->getContent());

            $exercise = new Exercise();
            $exercise->subject_id = $data[2][0]->subject;
            $exercise->type_id = 3;
            $exercise->available = 1;
            $exercise->title = $data[0];
            $exercise->description = $data[1];
            $exercise->save();

            foreach ($data[2] as $index => $d) {
                $drag_and_drop = new DragDrop();
                $s = Subject::find($d->subject);
                $drag_and_drop->description = $s->name;
                $drag_and_drop->text_question = 'nao sei se e necessario';
                $drag_and_drop->save();
                foreach ($d->options as $option) {
                    $answer = new CorrectAnswer();
                    $answer->drag_drop_id = $drag_and_drop->id;
                    $answer->answer = $option->optionField;
                    $answer->save();
                }
                $drag_and_drop->question()->create([
                    'exercise_id' => $exercise->id
                ]);
            }
            \DB::commit();
            return response()->json(['status' => 'Exercise created successfully']);
        }catch(\Exception $exception){
            \DB::rollback();
            return response()->json(['error' => $exception]);
        }
    }

    public function solve(Exercise $exercise)
    {
        $id = $exercise->id;
        if($exercise->type_id===3){
            return view('pages.student-side.exercise.drag-and-drop', ['exercise' => $id]);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\DragDrop  $dragDrop
     * @return \Illuminate\Http\Response
     */
    public function show(DragDrop $dragDrop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DragDrop  $dragDrop
     * @return \Illuminate\Http\Response
     */
    public function edit(DragDrop $dragDrop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DragDrop  $dragDrop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DragDrop $dragDrop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DragDrop  $dragDrop
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try{
            $questions = Question::where('exercise_id', '=', $id)->get();
            foreach ($questions as $question){
                CorrectAnswer::where('drag_drop_id',$question->questionable_id)->delete();
                DragDrop::where('id',$question->questionable_id)->delete();
            }

            Question::where('exercise_id', '=', $id)->delete();
            Exercise::destroy($id);

            return response()->json([
                'message'   => 'Deleted with success'
            ], 200);

        }catch (Exception $exception) {
            \DB::rollback();
            return response()->json(['error' => $exception], 500);
        }
    }
    public function getRandomDND(Request $request){
        $exercises = Exercise::where('type_id',3)->where('subject_id',$request->subject)->get();
        //faltam validacoes para verificar que existe pelo menos um jogo
        $number = rand(1,count($exercises));
        $questions = Question::where('exercise_id', $number)->get();
        $dndNames = [];
        foreach($questions as $key => $question)
        {
            $dndNames[$key] = DragDrop::where('id', $question->questionable_id)->get();
        }
        $dnd[] = array();
        $answers = [];
        foreach ($dndNames as $key => $dndName)
        {
            $objAnswers = CorrectAnswer::where('drag_drop_id',$dndName[0]->id)->get();
            foreach($objAnswers as $k => $objAnswer)
            {
                $answers[$k] = $objAnswer->answer;
            }
            $dnd[$key] = array($dndName[0]->description, $answers);
        }
        return response()->json($dnd,200);
    }

    public function  getDndById($id){

        $questions = Question::where('exercise_id', $id)->get();
        foreach($questions as $key => $question)
        {
            $dndNames[$key] = DragDrop::where('id', $question->questionable_id)->get();
        }

        $dnd[] = array();
        $answers = [];
        foreach ($dndNames as $key => $dndName)
        {
            $objAnswers = CorrectAnswer::where('drag_drop_id',$dndName[0]->id)->get();
            foreach($objAnswers as $k => $objAnswer)
            {
                $answers[$k] = $objAnswer->answer;
            }
            $dnd[$key] = array($dndName[0]->description, $answers);
        }
        return response()->json($dnd,200);
    }
}
