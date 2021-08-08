@extends('master.main')

@section('content')

    @component('components.teacher-side.classes.class-list',['groups'=>$groups])
    @endcomponent

@endsection
