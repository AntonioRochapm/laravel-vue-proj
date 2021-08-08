@extends('master.main')

@section('content')

    @component('components.student-side.student-select-exercise-type', ['types'=>$types, 'subject'=>$subject])
    @endcomponent

@endsection
