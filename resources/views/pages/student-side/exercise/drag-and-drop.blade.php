@extends('master.main')

@section('content')
    @component('components.student-side.exercises.drag-and-drop',[ 'exercise' => $exercise])
    @endcomponent
@endsection
