@extends('master.main')

@section('content')
    @component('components.teacher-side.exercises.create-drag-and-drop',['subject' => $subject])
    @endcomponent
@endsection
