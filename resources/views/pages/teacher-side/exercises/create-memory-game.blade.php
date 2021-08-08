@extends('master.main')

@section('content')
    @component('components.teacher-side.exercises.create-memory-game',['subject' => $subject])
    @endcomponent
@endsection
