@extends('master.main')

@section('content')

    @component('components.teacher-side.exercises.select-subject-type-exercise',['subjects'=>$subjects,'types'=>$types])
    @endcomponent

@endsection
