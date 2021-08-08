@extends('master.main')

@section('content')

    @component('components.teacher-side.exam.exams-list',['exams'=>$exams]);
    @endcomponent

@endsection



