@extends('master.main')

@section('content')
    @component('components.teacher-side.exercises.create-flashcard',['subject'=>$subject])
    @endcomponent
@endsection


