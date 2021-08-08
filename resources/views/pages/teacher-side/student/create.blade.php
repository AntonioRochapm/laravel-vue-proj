@extends('master.main')

@section('content')

    @component('components.teacher-side.student.student-form-create',['classes'=>$classes])
    @endcomponent

@endsection
