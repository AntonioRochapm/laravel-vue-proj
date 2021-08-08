@extends('master.main')

@section('content')

    @component('components.teacher-side.classes.class-form-show',['group'=>$group,'students'=>$students])
    @endcomponent

@endsection
