<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\FlashcardImage;
use App\MemoryGame;
use App\Question;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FlashcardImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Exercise $exercise
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function solve(Exercise $exercise)
    {

        if($exercise->type_id===1){
            $questions = Question::where('exercise_id', $exercise->id)->get();
            $i = 0;
            $flashcards = array();

            foreach ($questions as $question) {
                $flashcards[$i] = FlashcardImage::where('id', $question->questionable_id)->get();
                $i++;
            }
            return view('pages.student-side.exercise.flashcards', ['flashcards' => $flashcards]);
        }

    }


    public function index()
    {
        $exs = Exercise::where('type_id',1)->get();
        return view('pages.teacher-side.exercises.list-flashcards', ['exs'=>$exs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create($subject)
    {
        return view('pages.teacher-side.exercises.create-flashcard', ['subject'=>$subject]);
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
        try{
            $exercise = new Exercise();
            $exercise->subject_id = $request->subject;
            $exercise->type_id = 1;
            $exercise->available = 1;
            $exercise->title = $request->exercise;
            $exercise->description = $request->description;
            $exercise->save();


            $numberOfFiles = count($request->image);

            for ($i = 0; $i < $numberOfFiles; $i++) {
               $fileName = $request->image[$i]->getClientOriginalName();
               $extension = $request->image[$i]->extension();
               if(
                   $extension === 'jpeg' ||
                   $extension === 'jpg'  ||
                   $extension === 'png'
                    ){
                        $request->image[$i]->storeAs('/public/Flashcards/'.$exercise->id, $fileName);
                        $url = Storage::url("Flashcards/" . $exercise->id . "/" . $fileName);
                        $flashcard = new FlashcardImage();
                        $flashcard->url_image = $url;
                        $flashcard->correct_answer = $request->answer[$i];

                        $flashcard->text_question = 'not using right now';
                        $flashcard->save();
                        $flashcard->question()->create(['exercise_id' => $exercise->id, 'questionable_id' => $flashcard->id]);


                    }
            }
            \DB::commit();
            return redirect('')->with('status', 'Exercise updated successfully');        }
        catch (Exception $exception) {
                \DB::rollback();
                return redirect('/exercises/asd')->with('status', 'Exercise failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FlashcardImage  $flashcardImage
     * @return \Illuminate\Http\Response
     */
    public function show(FlashcardImage $flashcardImage)
    {


        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param Exercise $exercise
         * @param \App\FlashcardImage $flashcardImage
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function edit(Exercise $exercise)
        {
            $questions = Question::where('exercise_id',$exercise->id)->get();
            $i=0;
            $flashcards=array();
            foreach($questions as $question)
            {
                $flashcards[$i] = FlashcardImage::where('id', $question->questionable_id)->get();
                $i++;
            }
            return view('pages.teacher-side.exercises.edit-flashcard', ['exercise'=>$exercise, 'flashcards'=>$flashcards]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param \Illuminate\Http\Request $request
         * @param FlashcardImage $flashcardImages
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
         */
        public function update(Request $request, Exercise $exercise)
        {

            $exercise->title = $request->title;
            $exercise->description = $request->description;
            $exercise->update();

            $questions = Question::where('exercise_id', $exercise->id)->get();
            $i = 0;
            $flashcards = array();
            foreach ($questions as $question) {
                $flashcards[$i] = FlashcardImage::where('id', $question->questionable_id)->get();
                $i++;
            }
            $x = 1;
            foreach ($flashcards as $flashcard) {
                try {
                    if ($request->hasFile('image')) {

                        if ($request->file('image')->isValid()) {
                            $validated = $request->validate([
                                'image' => 'mimes:jpeg,jpg,png|max:700014',
                            ]);
                            $extension = $request->image->extension();
                            $request->file('image')->storeAs('/public/Flashcards/', $request['question1'] . "." . $extension);
                            $url = Storage::url("Flashcards/" . $request['question1'] . "." . $extension);
                            $flashcard[0]->url_image = $url;
                        }

                    }
                    $flashcard[0]->correct_answer = $request->{"question" . $x};
                    $flashcard[0]->text_question = 'asdsfesefsef';
                    $flashcard[0]->update();
                    $x++;

                } catch (Exception $exception) {
                    return redirect('/exercises/')->with('status', 'Exercise failed');
                }

            }

            return redirect('/exercises/flashcards')->with('status', 'Exercise updated successfully');
        }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\FlashcardImage $flashcardImage
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy($id)
    {

        \DB::beginTransaction();
        try{
            $questions = Question::where('exercise_id', '=', $id)->get();

            foreach ($questions as $question){
                FlashcardImage::where('id',$question->questionable_id)->delete();
            }

            Question::where('exercise_id', '=', $id)->delete();
            Exercise::destroy($id);


            //Deleting the FlashCards images stored in the server.
            if(Storage::exists("/public/Flashcards/".$id)){
                Storage::deleteDirectory("/public/Flashcards/".$id);
            }

            DB::commit();
            return response()->json([
                'message'   => 'Deleted with success'
            ], 200);

        }catch (\mysql_xdevapi\Exception $exception) {
            \DB::rollback();
            return response()->json(['error' => $exception], 500);
        }
    }
    public function teste(){
        $i =2;
    }
}
