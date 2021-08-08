@extends('master.main')

@section('content')

    @component('components.teacher-side.student.student-form-edit',['groups'=>$groups,'student'=>$student])
    @endcomponent

@endsection
