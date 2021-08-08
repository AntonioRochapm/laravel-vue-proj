<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\MemoryGame;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use mysql_xdevapi\Exception;
use Ramsey\Uuid\Type\Integer;
use function mysql_xdevapi\getSession;
use Illuminate\Support\Facades\DB;


class   MemoryGameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {

    }

    public function solve($id)
    {

        $questions = Question::where('exercise_id', $id)->get();
        $i = 0;
        $memoryGames = array();
        foreach ($questions as $question) {
            $memoryGames[$i] = MemoryGame::where('id', $question->questionable_id)->get();
            $i++;
        }

        return view('pages.student-side.exercise.memory-game', ['memoryGames' => $memoryGames]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create($subject)
    {
        return view('pages.teacher-side.exercises.create-memory-game', ['subject'=> $subject]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        \DB::beginTransaction();
        try {
            $exercise = new Exercise();
            if (!empty($request->subject)) {
                $exercise->subject_id = $request->subject;
                $exercise->type_id = 2;
                $exercise->available = 1;
                $exercise->title = $request->title;
                $exercise->description = $request->description;
                $exercise->save();
            }
            $numberOfQuestions = count($request->files);
            for ($i = 1; $i < $numberOfQuestions + 1; $i++) {
                if ($request->hasFile('image' . $i)) {
                    if ($request->file('image' . $i)->isValid()) {
                        $fileName = $i . $request->file('image' . $i)->getClientOriginalName();
                        $validated = $request->validate([
                            'image' . $i => 'mimes:jpeg,jpg,png|max:700014000',
                        ]);
                        $extension = $request->file('image' . $i)->extension();
                        $request->file('image' . $i)->storeAs('/public/MemoryGames/' . $exercise->id, $fileName);
                        $url = Storage::url("MemoryGames/" . $exercise->id . "/" . $fileName);
                    } else {
                        $url = "null";
                    }
                }

                $memory_game = new MemoryGame();
                $memory_game->url_image = $url;
                $memory_game->name =$request->{'question'.$i};
                $memory_game->save();
                $memory_game->question()->create(['exercise_id' => $exercise->id, 'questionable_id' => $memory_game->id]);
            }
            \DB::commit();
            return redirect('/')->with('status', 'Exercise created successfully');
        }
        catch (Exception $exception) {
            dd($exception);
                \DB::rollback();
                return redirect('/exercises/')->with('status', 'Exercise failed');
            }

}



    /**
     * Display the specified resource.
     *
     * @param  \App\MemoryGame  $memoryGame
     * @return \Illuminate\Http\Response
     */
    public function show(MemoryGame $memoryGame)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MemoryGame  $memoryGame
     * @return \Illuminate\Http\Response
     */
    public function edit(MemoryGame $memoryGame)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MemoryGame  $memoryGame
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MemoryGame $memoryGame)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MemoryGame  $memoryGame
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        \DB::beginTransaction();
        try{
            $questions = Question::where('exercise_id', '=', $id)->get();

            foreach ($questions as $question){
                MemoryGame::where('id',$question->questionable_id)->delete();
            }

            Question::where('exercise_id', '=', $id)->delete();
            Exercise::destroy($id);


            //Deleting the memory-game images stored in the server.
            if(Storage::exists("/public/MemoryGames/".$id)){
                Storage::deleteDirectory("/public/MemoryGames/".$id);
            }

            \DB::commit();
            return response()->json([
                'message'   => 'Deleted with success'
            ], 200);

        }catch (Exception $exception) {
            \DB::rollback();
            return response()->json(['error' => $exception], 500);
        }
    }
}
