<?php

namespace App\Http\Controllers;

use App\CorrectAnswer;
use App\DragDrop;
use App\Exercise;
use App\Question;
use App\Subject;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentSideController extends Controller
{
    public function index()
    {
        $subjects = Subject::all();

        return view('pages.student-side.index', ['subjects'=>$subjects]);
    }

    public function showDnd()
    {
        return view('pages.student-side.exercises.drag-and-drop');
    }


    //return JSON Funtions
    public function getDND(){
        $exercises = Exercise::where('type_id',3)->get();
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
            foreach($objAnswers as $key => $objAnswer)
            {
                $answers[$key] = $objAnswer->answer;
            }
            $dnd[$key] = array($dndName[0]->description, $answers);
        }
        return response()->json($dnd,200);
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
}
